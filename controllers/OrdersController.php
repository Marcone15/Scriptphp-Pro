<?php

namespace controller;

use models\Order;
use models\Campaign;
use SplFileObject;

class OrdersController {
    private $orderModel;
    private $campaignModel;

    public function __construct($pdo) {
        $this->orderModel = new Order($pdo);
        $this->campaignModel = new Campaign($pdo); 
    }

    public function showOrders() {
        $orders = [];
        $searchPerformed = false;
        $limit = 10; 
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $limit;

        if (isset($_GET['phone'])) {
            $phone = $_GET['phone'];
            $orders = $this->orderModel->getOrdersByPhone($phone, $limit, $offset);
            $totalOrders = $this->orderModel->getTotalOrdersByPhone($phone);
            $searchPerformed = true;
        } else {
            $totalOrders = 0;
        }

        $totalPages = ceil($totalOrders / $limit);

        $this->render('meusnumeros', [
            'orders' => $orders, 
            'searchPerformed' => $searchPerformed, 
            'currentPage' => $currentPage, 
            'totalPages' => $totalPages,
            'phone' => $phone ?? ''
        ]);
    }

    public function showAllOrders() {
        $campaignId = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : '';
        $orderHash = isset($_GET['order_hash']) ? $_GET['order_hash'] : '';
        $titleNumber = isset($_GET['title_number']) ? $_GET['title_number'] : '';
        $clientName = isset($_GET['client_name']) ? $_GET['client_name'] : '';
        
        $limit = 15;
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $limit;
    
        $orders = $this->orderModel->getFilteredOrders($campaignId, $orderHash, $titleNumber, $clientName, $limit, $offset);
        $totalOrders = $this->orderModel->getTotalFilteredOrders($campaignId, $orderHash, $titleNumber, $clientName); 
    
        $totalPages = ceil($totalOrders / $limit);
        $campaigns = $this->campaignModel->getAllCampaigns();
    
        $this->renderDashboard('orders', [
            'orders' => $orders, 
            'campaigns' => $campaigns,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages
        ]);
    } 

    public function getAllCampaigns() {
        $campaigns = $this->campaignModel->getAllCampaigns();
        header('Content-Type: application/json');
        echo json_encode($campaigns);
    }

    public function deleteOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $orderId = $data['id'] ?? null;
    
            if ($orderId) {
                $success = $this->orderModel->deleteOrder($orderId); 
    
                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
    }

    public function editOrder($id) {
        $order = $this->orderModel->getOrderById($id); 
    
        if (!$order) {
            header("HTTP/1.0 404 Not Found");
            echo "Pedido não encontrado";
            exit();
        }
    
        $campaign = $this->campaignModel->getCampaignById($order['id_campaign']); 
        $user = $this->orderModel->getUserById($order['id_user']); 
    
        $this->renderDashboard('editorder', [
            'order' => $order,
            'campaign' => $campaign,
            'user' => $user
        ]);
    }  

    private function renderDashboard($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/dashboard/{$viewName}.php";
    }

    public function cancelOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            
            $order = $this->orderModel->getOrderById($id);
            $campaign = $this->campaignModel->getCampaignById($order['id_campaign']);
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
    
            $this->orderModel->updateOrder([
                'id' => $id,
                'payment_status' => 'cancelado',
                'quantity' => 0,
                'numbers' => '',
                'total' => '0,00'
            ]);
    
            header('Location: /dashboard/orders');
            exit();
        }
    }    

    public function confirmOrder() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $typeRaffle = $_POST['type_raffle'];
    
            $this->orderModel->updatePaymentStatus($id, 'pago');
    
            header('Location: /dashboard/orders');
            exit();
        }
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

    private function render($viewName, $viewData = []) {
        extract($viewData);
        require __DIR__ . "/../views/pages/{$viewName}.php";
    }

}
?>
