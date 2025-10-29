<?php
require __DIR__ . '/config/config.php';

if (!isset($_GET['pix_url'])) {
    echo json_encode(['status' => 'error', 'message' => 'Pix URL is missing.']);
    exit();
}

$pixUrl = $_GET['pix_url'];

try {
    $stmt = $pdo->prepare('UPDATE orders SET payment_status = ? WHERE pix_url = ?');
    $stmt->execute(['pago', $pixUrl]);
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
