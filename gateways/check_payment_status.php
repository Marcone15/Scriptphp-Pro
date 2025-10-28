<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once __DIR__ . '/log_util.php'; 
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Order.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

logMessage('check_payment_status.php called', 'gerencianet.log');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['efiBankConfig'])) {
    echo json_encode(['status' => 'error', 'message' => 'Configuração do gateway não encontrada.']);
    exit();
}

$gnConfig = $_SESSION['efiBankConfig'];

if ($gnConfig) {
    $options = [
        'client_id' => $gnConfig['client_id'],
        'client_secret' => $gnConfig['client_secret'],
        'sandbox' => false,
        'pix_cert' => __DIR__ . '/../certs/' . $gnConfig['pix_cert']
    ];
} else {
    echo json_encode(['status' => 'error', 'message' => 'Configuração do gateway não encontrada.']);
    exit();
}

$txid = $_GET['txid'];
$pixUrl = $_GET['pix_url']; 
logMessage('TXID: ' . $txid, 'gerencianet.log');

try {
    $api = new Gerencianet($options);
    $params = ['txid' => $txid];
    $response = $api->pixDetailCharge($params);
    logMessage('API Response: ' . json_encode($response), 'gerencianet.log');
    
   
    if (isset($response['status']) && $response['status'] === 'CONCLUIDA') {
        logMessage('Payment confirmed for TXID: ' . $txid, 'gerencianet.log');
        
        $orderModel = new \models\Order($pdo);
        $orderModel->setPaymentStatusToPaid($pixUrl);

        echo json_encode(['status' => 'paid']);
    } else {
        logMessage('Payment pending for TXID: ' . $txid, 'gerencianet.log');
        echo json_encode(['status' => 'pending']);
    }
} catch (GerencianetException $e) {
    logMessage('Erro: ' . $e->code, 'gerencianet.log');
    logMessage('Erro: ' . $e->error, 'gerencianet.log');
    logMessage('Erro: ' . $e->errorDescription, 'gerencianet.log');
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} catch (Exception $e) {
    logMessage('Erro: ' . $e->getMessage(), 'gerencianet.log');
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
