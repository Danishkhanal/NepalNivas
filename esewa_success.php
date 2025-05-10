<?php
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}

// Get the encoded response data from the query parameter
if(isset($_GET['data'])) {
    // Decode the base64 response
    $decoded_data = base64_decode($_GET['data']);
    
    // Add error logging to debug the response
    error_log("Decoded eSewa Response: " . $decoded_data);
    
    // Try to decode JSON and handle potential errors
    $response_data = json_decode($decoded_data, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Log JSON decode error
        error_log("JSON Decode Error: " . json_last_error_msg());
        
        // Display error message
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Processing Error</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                .container {
                    max-width: 600px;
                    margin-top: 50px;
                    text-align: center;
                }
                .error-message {
                    color: #dc3545;
                    font-size: 1.5rem;
                    margin-bottom: 20px;
                }
                .home-button {
                    margin-top: 30px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="error-message">
                    <h2>Payment Processing Error</h2>
                    <p>We encountered an error while processing your payment response.</p>
                    <p>Please contact support if this issue persists.</p>
                </div>
                <a href="index.php" class="btn btn-primary home-button">Return to Home</a>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>';
        exit;
    }

    // Print the response data for debugging
    error_log("Response Data: " . print_r($response_data, true));

    if ($response_data && isset($response_data['transaction_code'])) {
        $transaction_code = $response_data['transaction_code'];
        $status = $response_data['status'] ?? '';
        $total_amount = $response_data['total_amount'] ?? 0;
        $transaction_uuid = $response_data['transaction_uuid'] ?? '';
        
        // Verify the transaction with eSewa
        $merchant_code = "EPAYTEST";
        $url = "https://rc.esewa.com.np/api/epay/transaction/status";
        
        $query_params = http_build_query([
            'transaction_uuid' => $transaction_uuid,
            'product_code' => $merchant_code,
            'total_amount' => str_replace(',', '', $total_amount),
        ]);

        $verification_url = $url . '?' . $query_params;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $verification_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Log verification response
        error_log("eSewa Verification Response: " . $response);
        error_log("HTTP Status: " . $http_status);

        if ($http_status === 200) {
            $verification_data = json_decode($response, true);
            
            if ($verification_data && $verification_data['status'] === 'COMPLETE') {
                // Payment successful, update database
                $query = "SELECT `booking_id`, `user_id` FROM `booking_order` WHERE `order_id`=?";
                $booking_res = select($query, [$transaction_uuid], 's');
                
                if(mysqli_num_rows($booking_res) > 0) {
                    $booking_fetch = mysqli_fetch_assoc($booking_res);
                    
                    $updateQuery = "UPDATE `booking_order` SET `booking_status`='booked', 
                        `trans_id`=?, `trans_amt`=?, `trans_status`='TXN_SUCCESS', 
                        `trans_resp_msg`='eSewa payment successful' 
                        WHERE `booking_id`=?";
                    
                    insert($updateQuery, [$transaction_code, str_replace(',', '', $total_amount), $booking_fetch['booking_id']], 'ssi');
                    
                    // Display success message with HTML and Bootstrap 5 styling
                    echo '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Payment Successful</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                        <style>
                            .container {
                                max-width: 600px;
                                margin-top: 50px;
                                text-align: center;
                            }
                            .success-message {
                                color: #28a745;
                                font-size: 1.5rem;
                                margin-bottom: 20px;
                            }
                            .home-button {
                                margin-top: 30px;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="success-message">
                                <h2>Payment Successful!</h2>
                                <p>Your booking has been confirmed.</p>
                                <p>Order ID: ' . $transaction_uuid . '</p>
                                <p>Transaction ID: ' . $transaction_code . '</p>
                            </div>
                            <a href="index.php" class="btn btn-primary home-button">Return to Home</a>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                    </body>
                    </html>';
                    exit;
                }
            } else {
                // Display error message for incomplete payment
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Payment Incomplete</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        .container {
                            max-width: 600px;
                            margin-top: 50px;
                            text-align: center;
                        }
                        .error-message {
                            color: #dc3545;
                            font-size: 1.5rem;
                            margin-bottom: 20px;
                        }
                        .home-button {
                            margin-top: 30px;
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <div class="error-message">
                            <h2>Payment Incomplete</h2>
                            <p>Your payment could not be completed. Please try again.</p>
                        </div>
                        <a href="index.php" class="btn btn-primary home-button">Return to Home</a>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
                </body>
                </html>';
                exit;
            }
        } else {
            // Display error message for verification failure
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Verification Failed</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    .container {
                        max-width: 600px;
                        margin-top: 50px;
                        text-align: center;
                    }
                    .error-message {
                        color: #dc3545;
                        font-size: 1.5rem;
                        margin-bottom: 20px;
                    }
                    .home-button {
                        margin-top: 30px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="error-message">
                        <h2>Verification Failed</h2>
                        <p>We could not verify your payment. Please contact support.</p>
                    </div>
                    <a href="index.php" class="btn btn-primary home-button">Return to Home</a>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>';
            exit;
        }
    } else {
        redirect('index.php');
    }
} else {
    redirect('index.php');
}
?> 