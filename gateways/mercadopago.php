<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($order['total'])) {
    $total = (float) str_replace(',', '.', $order['total']);
} else {
    $total = 0.00; 
}

spl_autoload_register(function ($class_name) {
    $base_dir = __DIR__ . '/../vendor/mercadopago/src/';
    $file = $base_dir . str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

$mercadopagoConfig = isset($_SESSION['paggueConfig']) ? $_SESSION['paggueConfig'] : null;

if ($mercadopagoConfig) {
    $clientKey = $mercadopagoConfig['client_key'];
    $clientSecret = $mercadopagoConfig['client_secret'];
    $apiUrl = $mercadopagoConfig['api_url'];
    $companyId = $mercadopagoConfig['company_id'];
} else {
    die("Configuração do gateway Paggue não encontrada.");
}

MercadoPagoConfig::setAccessToken($clientKey);

function criarPagamentoPix($transaction_amount, $description, $email) {
    $client = new PaymentClient();
    
    $request = [
        "transaction_amount" => $transaction_amount,
        "description" => $description,
        "installments" => 1,
        "payment_method_id" => "pix",
        "payer" => [
            "email" => $email,
        ]
    ];
    
    $request_options = new RequestOptions();
    $request_options->setCustomHeaders(["X-Idempotency-Key: " . uniqid()]);

    try {
        $payment = $client->create($request, $request_options);
        return $payment;
    } catch (MPApiException $e) {
        echo "Status code: " . $e->getApiResponse()->getStatusCode() . "\n";
        echo "Content: ";
        var_dump($e->getApiResponse()->getContent());
        echo "\n";
        return null;
    } catch (\Exception $e) {
        echo $e->getMessage();
        return null;
    }
}

$transaction_amount = $total;
$description = "Descrição do pagamento";
$email = "usuario@teste.com";

$pagamento = criarPagamentoPix($transaction_amount, $description, $email);

?>

<script>
    function checkPaymentStatus(paymentId, pixUrl) {
        setInterval(() => {
            console.log(`Verificando status do pagamento para Payment ID: ${paymentId}`);
            fetch(`/gateways/check_payment_status_mp.php?payment_id=${encodeURIComponent(paymentId)}`)
                .then(response => response.json())
                .then(data => {
                    console.log(`Dados recebidos: `, data);
                    if (data.status === 'approved') {
                        console.log('Pagamento aprovado.');
                        fetch(`/update_payment_status.php?pix_url=${encodeURIComponent(pixUrl)}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    console.log('Status do pagamento atualizado para "pago".');
                                    location.reload();
                                } else {
                                    console.error('Erro ao atualizar o status do pagamento:', data.message);
                                }
                            })
                            .catch(error => console.error('Erro ao atualizar o status do pagamento:', error));
                    } else if (data.status === 'pending') {
                        console.log('Pagamento pendente...');
                    } else if (data.status === 'in_process') {
                        console.log('Pagamento em processamento...');
                    } else if (data.status === 'rejected') {
                        console.error('Pagamento rejeitado.');
                    } else {
                        console.error('Erro ao verificar pagamento:', data.message || 'Status desconhecido.');
                    }
                })
                .catch(error => console.error('Erro ao buscar status do pagamento:', error));
        }, 5000);
    }

    const paymentId = "<?php echo htmlspecialchars($pagamento->id); ?>";
    const pixUrl = "<?php echo htmlspecialchars($order['pix_url']); ?>";

    if (paymentId && pixUrl) {
        checkPaymentStatus(paymentId, pixUrl);
    } else {
        console.error('Payment ID ou pixUrl não está definido.');
    }
</script>
