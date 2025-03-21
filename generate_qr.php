<?php
require_once "phpqrcode/qrlib.php"; // Include QR Code library

if (isset($_GET['amount']) && isset($_GET['method'])) {
    $amount = $_GET['amount'];
    $method = $_GET['method'];

    // Generate QR Code content
    $data = "Payment Method: $method\nAmount: $amount";
    
    // Output QR Code as PNG
    header('Content-Type: image/png');
    QRcode::png($data);
}
?>
