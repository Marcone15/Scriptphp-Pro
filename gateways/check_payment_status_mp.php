<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function logMessage($message) {
    $logFilePath = __DIR__ . '/../logs/mercadopago.log';
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = $timestamp . " - " . $message . PHP_EOL;

    file_put_contents($logFilePath, $logEntry);
}

logMessage("Script iniciado");

if (!isset($_GET['payment_id'])) {
    logMessage('Payment ID is missing.');
    echo json_encode(['status' => 'error', 'message' => 'Payment ID is missing.']);
    exit;
}

$paymentId = $_GET['payment_id'];
logMessage("Payment ID recebido: $paymentId");

$mercadopagoConfig = isset($_SESSION['paggueConfig']) ? $_SESSION['paggueConfig'] : null;

if ($mercadopagoConfig) {
    $clientKey = $mercadopagoConfig['client_key'];
    $clientSecret = $mercadopagoConfig['client_secret'];
    $apiUrl = $mercadopagoConfig['api_url'];
    $companyId = $mercadopagoConfig['company_id'];
} else {
    die("Configuração do gateway Paggue não encontrada.");
}

$accessToken = $clientKey;
logMessage("Token de acesso definido diretamente");

$url = 'https://api.mercadopago.com/v1/payments/' . $paymentId;
$headers = [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json',
];

logMessage("URL: $url");
logMessage("Authorization: Bearer " . substr($accessToken, 0, 5) . "...");

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => false,
    CURLOPT_SSL_VERIFYPEER => false,
]);
$response = curl_exec($curl);

if (curl_errno($curl)) {
    $errorMessage = curl_error($curl);
    logMessage("cURL error: $errorMessage");
    echo json_encode(['status' => 'error', 'message' => 'cURL error: ' . $errorMessage]);
    curl_close($curl);
    exit;
}

$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

logMessage("HTTP Code: $httpCode");
logMessage("Response: $response");

if ($httpCode == 401) {
    logMessage("Unauthorized access. Please check your access token.");
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access. Please check your access token.']);
    exit;
}

if ($response === false) {
    logMessage("Failed to get response from Mercado Pago API.");
    echo json_encode(['status' => 'error', 'message' => 'Failed to get response from Mercado Pago API.']);
    exit;
}

$paymentData = json_decode($response, true);

if (isset($paymentData['status'])) {
    echo json_encode(['status' => $paymentData['status']]);
} else {
    logMessage("Payment status not found in response.");
    echo json_encode(['status' => 'error', 'message' => 'Payment status not found.']);
}

logMessage('Script execution completed.');

?>
