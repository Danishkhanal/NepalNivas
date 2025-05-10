<?php
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

if (isset($_GET['order_id']) && isset($_GET['amount'])) {
    $ORDER_ID = $_GET['order_id'];
    $TXN_AMOUNT = $_GET['amount'];

    // eSewa test credentials
    $merchant_code = "EPAYTEST"; //test merchant code
    $secret_key = "8gBm/:&EnhH.1/q"; // eSewa test secret key
    
    // Use full URLs for success and failure
    $success_url = "http://" . $_SERVER['HTTP_HOST'] . "/NepalNivas/esewa_success.php";
    $failure_url = "http://" . $_SERVER['HTTP_HOST'] . "/NepalNivas/esewa_failure.php";

    // eSewa test endpoint
    $esewa_url = "https://rc-epay.esewa.com.np/api/epay/main/v2/form";

    // Generate transaction UUID using order ID to maintain consistency
    $transaction_uuid = $ORDER_ID;

    // Parameters for eSewa payment
    $params = [
        'amount' => $TXN_AMOUNT,
        'tax_amount' => '0',
        'total_amount' => $TXN_AMOUNT,
        'transaction_uuid' => $transaction_uuid,
        'product_code' => $merchant_code,
        'product_service_charge' => '0',
        'product_delivery_charge' => '0',
        'success_url' => $success_url,
        'failure_url' => $failure_url,
        'signed_field_names' => 'total_amount,transaction_uuid,product_code',
    ];

    // Generate signature
    $string_to_sign = "total_amount=" . $params['total_amount'] . 
                      ",transaction_uuid=" . $params['transaction_uuid'] . 
                      ",product_code=" . $params['product_code'];

    $signature = base64_encode(hash_hmac('sha256', $string_to_sign, $secret_key, true));
    $params['signature'] = $signature;

    // Add error logging
    error_log("eSewa Payment Request - Order ID: " . $ORDER_ID);
    error_log("Payment Parameters: " . print_r($params, true));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to eSewa...</title>
    <style>
        .loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="loading-container">
        <div class="spinner"></div>
        <p>Redirecting to eSewa payment gateway...</p>
    </div>
    <form action="<?php echo $esewa_url; ?>" method="POST" id="esewa_form">
        <?php foreach ($params as $key => $value) { ?>
            <input type="hidden" name="<?php echo $key; ?>" value="<?php echo htmlspecialchars($value); ?>">
        <?php } ?>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('esewa_form').submit();
            }, 1500);
        });
    </script>
</body>
</html>

<?php
} else {
    redirect('index.php');
}
?> 