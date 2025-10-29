<?php
namespace controller;

use model\Gateway;

class GatewayController {
    private $pdo;
    private $gatewayModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->gatewayModel = new Gateway($pdo);
    }

    public function showGateways() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $gateways = $this->gatewayModel->getAllGateways();
        
        if (!empty($gateways)) {
            $_SESSION['efiBankConfig'] = [
                'client_id' => $gateways[0]['client_id'],
                'client_secret' => $gateways[0]['client_secret'],
                'sandbox' => false,
                'pix_key' => $gateways[0]['pix_key'],
                'pix_cert' => $gateways[0]['pix_cert']
            ];
    
            if (isset($gateways[1])) {
                $_SESSION['paggueConfig'] = [
                    'client_key' => $gateways[1]['client_id'],
                    'client_secret' => $gateways[1]['client_secret'],
                    'api_url' => $gateways[1]['api_url'],
                    'company_id' => $gateways[1]['company_id']
                ];
            }
        }
        
        require __DIR__ . '/../views/dashboard/gateways.php';
    }

    public function updateGateway() {
        $data = $_POST;
        $files = $_FILES;
    
        function processGatewayFormData($data, $files) {
            $client_id = !empty($data['client_id']) ? $data['client_id'] : null;
            $client_secret = !empty($data['client_secret']) ? $data['client_secret'] : null;
            $pix_key = !empty($data['pix_key']) ? $data['pix_key'] : null;
            $pix_cert = !empty($files['pix_cert']['name']) ? uniqid() . '_' . basename($files['pix_cert']['name']) : (!empty($data['pix_cert_old']) ? $data['pix_cert_old'] : null);
    
            if (!empty($files['pix_cert']['name'])) {
                move_uploaded_file($files['pix_cert']['tmp_name'], __DIR__ . '/../certs/' . $pix_cert);
            }
    
            $company_id = !empty($data['company_id']) ? $data['company_id'] : null;
            $api_url = !empty($data['api_url']) ? $data['api_url'] : null;
            $id = $data['id'];
    
            return [
                'id' => $id,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'pix_key' => $pix_key,
                'pix_cert' => $pix_cert,
                'company_id' => $company_id,
                'api_url' => $api_url
            ];
        }
    
        $gatewayData = processGatewayFormData($data, $files);
    
        $stmt = $this->pdo->prepare('UPDATE gateways SET client_id = ?, client_secret = ?, pix_key = ?, pix_cert = ?, company_id = ?, api_url = ? WHERE id = ?');
        $stmt->execute([
            $gatewayData['client_id'],
            $gatewayData['client_secret'],
            $gatewayData['pix_key'],
            $gatewayData['pix_cert'],
            $gatewayData['company_id'],
            $gatewayData['api_url'],
            $gatewayData['id']
        ]);
    
        header('Location: /dashboard/gateways');
        exit();
    }

    public function getGateways() {
        return $this->gatewayModel->getAllGateways();
    }
}
?>
