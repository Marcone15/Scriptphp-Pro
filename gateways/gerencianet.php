<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'vendor/autoload.php';
require_once __DIR__ . '/log_util.php'; 

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

if (!isset($_SESSION['efiBankConfig'])) {
    die("Configuração do gateway não encontrada. Conteúdo da sessão: " . print_r($_SESSION, true));
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
    die("Configuração do gateway não encontrada.");
}

$total = number_format((float)str_replace(',', '.', $order['total']), 2, '.', '');
$cpf = isset($order['user_cpf']) && !empty($order['user_cpf']) ? preg_replace('/\D/', '', $order['user_cpf']) : '27268629850';
$name = $order['user_name'];

$body = [
    'calendario' => ['expiracao' => 3600],
    'devedor' => [
        'cpf' => $cpf,
        'nome' => $name
    ],
    'valor' => [
        'original' => $total
    ],
    'chave' => $gnConfig['pix_key'],
    'infoAdicionais' => [
        ['nome' => 'Observação', 'valor' => 'Informações adicionais']
    ]
];

try {
    $api = new Gerencianet($options);
    $pix = $api->pixCreateImmediateCharge([], $body);
    $qrcode = $api->pixGenerateQRCode(['id' => $pix['loc']['id']]);
    $copiaECola = $qrcode['qrcode'];
    $imagemQRCode = $qrcode['imagemQrcode'];
    $txid = $pix['txid']; 
    logMessage('PIX payment created successfully. TXID: ' . $txid, 'gerencianet.log');
} catch (GerencianetException $e) {
    logMessage('Erro: ' . $e->code, 'gerencianet.log');
    logMessage('Erro: ' . $e->error, 'gerencianet.log');
    logMessage('Erro: ' . $e->errorDescription, 'gerencianet.log');
    $txid = ''; 
} catch (Exception $e) {
    logMessage('Erro: ' . $e->getMessage(), 'gerencianet.log');
    $txid = ''; 
}


?>
<script>
    function checkPaymentStatus(txid, pixUrl) {
        setInterval(function() {
            
            fetch('/gateways/check_payment_status.php?txid=' + txid + '&pix_url=' + pixUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'paid') {
                        console.log('Order status updated successfully.');
                        location.reload(); 
                    } else if (data.status === 'pending') {
                        console.log('Payment is still pending...');
                    } else {
                        console.error('Error checking payment status:', data.message);
                    }
                })
                .catch(error => console.error('Error fetching payment status:', error));
        }, 5000); 
    }

    const txid = "<?php echo $txid; ?>";
    const pixUrl = "<?php echo $order['pix_url']; ?>";
    checkPaymentStatus(txid, pixUrl);
</script>

