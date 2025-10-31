<?php
namespace controller;

use models\Campaign;
use models\Order;
use models\User;
use DateTime;
use DateTimeZone;
use Exception;

class PurchaseController {
    private $campaignModel;
    private $orderModel;
    private $userModel;

    public function __construct($pdo) {
        $this->campaignModel = new Campaign($pdo);
        $this->orderModel = new Order($pdo);
        $this->userModel = new User($pdo);
    }

    public function checkPhone($phone) {
        return $this->userModel->getUserByPhone($phone);
    }  
    

    public function createOrder($data) {
        $this->cancelAnyPendingOrder();
    
        $data['numbers'] = ($data['type_raffle'] === 'Normal' || $data['type_raffle'] === 'Fazendinha') ? $data['numbers_list'] : '';
        $data['pix_url'] = uniqid(); 
        $expirationDate = date('Y-m-d H:i:s', strtotime('+' . $data['expiration_pix'] . ' minutes'));
        $adjustedExpirationDate = date('Y-m-d H:i:s', strtotime($expirationDate));
        $data['expiration_date'] = $adjustedExpirationDate;
        $data['hash_order'] = substr(md5(uniqid(rand(), true)), 0, 8); 
    
        $quantity = $data['quantity'];
        $campaign = $this->campaignModel->getCampaignById($data['id_campaign']);
        $qtd_promo = explode(', ', $campaign['qtd_promo']);
        $price_promo = explode(', ', $campaign['price_promo']);
    
        if (in_array($quantity, $qtd_promo)) {
            $index = array_search($quantity, $qtd_promo);
            $data['total'] = $price_promo[$index];
        } else {
            $price = str_replace(',', '.', $campaign['price']);
            $data['total'] = number_format(floatval($price) * $quantity, 2, '.', '');
        }
    
        if (empty($data['total']) || $data['total'] == 0) {
            $price = str_replace(',', '.', $campaign['price']);
            $data['total'] = number_format(floatval($price) * $quantity, 2, '.', '');
        }
    
        $data['campaign_name'] = $data['campaign']; 
        $data['type_raffle'] = $data['type_raffle'];
    
        error_log("Dados finais para criar pedido: " . print_r($data, true));
    
        $orderId = $this->orderModel->createOrder($data);
    
        if ($data['type_raffle'] === 'Automática') {
            $this->generateNumbers($orderId);
        }
    
        $createdAt = $this->orderModel->getCreatedAt($orderId);
    
        $expirationDate = new DateTime($data['expiration_date']);
        $expirationDate->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $adjustedExpirationDate = $expirationDate->format('Y-m-d H:i:s');
    
        $this->campaignModel->updateMinMaxTitles($data['id_campaign']);
    
        return [
            'id_campaign' => $data['id_campaign'],
            'campaign_name' => $data['campaign_name'],
            'type_raffle' => $data['type_raffle'],
            'quantity' => $data['quantity'],
            'numbers' => $data['numbers'],
            'total' => $data['total'],
            'price' => $price,
            'payment_status' => $data['payment_status'],
            'pix_url' => $data['pix_url'],
            'expiration_date' => $adjustedExpirationDate,
            'hash_order' => $data['hash_order'],
            'expiration_pix' => $data['expiration_pix'], 
            'created_at' => $createdAt 
        ];
    }
    

    public function cancelAnyPendingOrder() {
        $pendingOrders = $this->orderModel->getPendingOrders();
    
        $timezone = new DateTimeZone('America/Sao_Paulo');
        $now = new DateTime('now', $timezone);
    
        foreach ($pendingOrders as $order) {
            if ($order['payment_status'] === 'pendente') {
                $expirationDate = new DateTime($order['expiration_date'], $timezone);
    
                if ($now >= $expirationDate) {
                    $campaign = $this->campaignModel->getCampaignById($order['id_campaign']);
    
                    if ($campaign['type_raffle'] === 'Automática') {
                        $filePath = __DIR__ . '/../campaigns/' . $campaign['numbers_file_path'];
    
                        $orderNumbers = $order['numbers'];
                        if (!empty($orderNumbers)) {
                            $orderNumbersArray = explode(', ', $orderNumbers);
    
                            $numbers = file_get_contents($filePath);
                            $numbersArray = explode(', ', $numbers);
    
                            $numbersArray = array_merge($numbersArray, $orderNumbersArray);
    
                            $numbersArray = array_unique($numbersArray);
                            sort($numbersArray, SORT_NUMERIC);
    
                            $numbersArray = array_filter($numbersArray, fn($number) => !empty($number));
    
                            $numbersString = implode(', ', $numbersArray);
                            file_put_contents($filePath, $numbersString);
                        }
                    }
    
                    $this->orderModel->updateOrder([
                        'id' => $order['id'],
                        'payment_status' => 'cancelado',
                        'quantity' => 0,
                        'numbers' => '',
                        'total' => '0,00'
                    ]);
                }
            }
        }
    }
    
    public function showOrder($pixUrl) {
        $order = $this->orderModel->getOrderByPixUrl($pixUrl);
    
        if (!$order) {
            echo 'Pedido não encontrado!';
            return;
        }
    
        include __DIR__ . '/../views/pages/orderDetails.php';
    }
    

    public function showThankYouPage($pix_url) {
    $order = $this->orderModel->getOrderByPixUrl($pix_url);

    if (!$order) {
        header('Location: /');
        exit('Pedido não encontrado.');
    }

    include __DIR__ . '/../views/pages/obrigado.php';
    }
    
    private function generateNumbers($orderId) {
        $order = $this->orderModel->getOrderById($orderId);
        $campaign = $this->campaignModel->getCampaignById($order['id_campaign']);
        $quantity = $order['quantity'];
        $filePath = __DIR__ . '/../campaigns/' . $campaign['numbers_file_path'];
    
        if (!file_exists($filePath)) {
            throw new Exception("Arquivo de números não encontrado.");
        }
    
        $selectedNumbers = [];
        $tempFilePath = __DIR__ . '/../campaigns/temp_' . $campaign['numbers_file_path'];
    
        $handle = fopen($filePath, 'r');
        $tempHandle = fopen($tempFilePath, 'w');
        if ($handle && $tempHandle) {
            while (!feof($handle) && count($selectedNumbers) < $quantity) {
                $char = fgetc($handle);
                if ($char === false) {
                    break;
                }
    
                if ($char !== ',') {
                    $buffer .= $char;
                $buffer = $buffer ?? '';

                } else {
                    if (count($selectedNumbers) < $quantity) {
                        $selectedNumbers[] = trim($buffer);
                    } else {
                        fwrite($tempHandle, $buffer . ', ');
                    }
                    $buffer = '';
                }
            }
    
            while (!feof($handle)) {
                fwrite($tempHandle, fread($handle, 4096));
            }
    
            fclose($handle);
            fclose($tempHandle);
        } else {
            throw new Exception("Não foi possível abrir o arquivo.");
        }
    
        $tempContent = file_get_contents($tempFilePath);
        $tempContent = rtrim($tempContent, ', ');
        file_put_contents($tempFilePath, $tempContent);
    
        rename($tempFilePath, $filePath);
    
        shuffle($selectedNumbers);
    
        $this->orderModel->updateOrderNumbers($orderId, implode(', ', $selectedNumbers));
    }

    public function getExpirationTime($pixUrl) {
        $order = $this->orderModel->getOrderByPixUrl($pixUrl);
        return $order ? $order['expiration_date'] : null;
    }
    
 
}
?>
