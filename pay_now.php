<?php 
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

// Include Stripe's PHP library
require_once('vendor/autoload.php'); // Ensure Stripe SDK is installed correctly

date_default_timezone_set("Asia/Kathmandu");

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
  redirect('index.php');
}

\Stripe\Stripe::setApiKey('sk_test_51Qvg87P8o5tuCFx3xjT0db2guee24USQ7MmFncZ2pits8g3jsyd9a79Au0RE1lCdVVq8xkPJ0EM3TL2zwr7eMbhN00If4lh8iE');

// Currency conversion functions
function getExchangeRateFromDB(
  $currency, $con) {
  $query = "SELECT `rate` FROM `exchange_rates` WHERE `currency` = ?";
  $stmt = $con->prepare($query);
  $stmt->bind_param('s', $currency);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row ? $row['rate'] : null;
}

function convertCurrency($amount, $from_currency, $to_currency, $con) {
  if ($from_currency == $to_currency) {
      return number_format($amount, 2, '.', '');
  }
  $from_rate = getExchangeRateFromDB($from_currency, $con);
  $to_rate = getExchangeRateFromDB($to_currency, $con);
  if ($from_rate && $to_rate) {
      $conversion_rate = $to_rate / $from_rate;
      return number_format($amount * $conversion_rate, 2, '.', '');
  }
  return number_format($amount, 2, '.', '');
}

if (isset($_POST['pay_now'])) {
  $payment_method = $_POST['payment_method']; // Get selected payment method
  $CUST_ID = $_SESSION['uId'];
  $selected_currency = $_SESSION['room']['currency'];
  $base_currency = 'NPR';
  $TXN_AMOUNT = $_SESSION['room']['payment'];
  $ORDER_ID = 'ORD_' . $_SESSION['uId'] . random_int(11111, 9999999);

  // Calculate the correct payment amount for the selected currency
  if ($payment_method === 'stripe') {
    $final_amount = convertCurrency($TXN_AMOUNT, $base_currency, $selected_currency, $con);
    $final_currency = $selected_currency;
  } else {
    $final_amount = $TXN_AMOUNT;
    $final_currency = 'NPR';
  }

  // Validate payment method against currency
  if (($selected_currency == 'NPR' && $payment_method != 'eSewa') || 
      ($selected_currency != 'NPR' && $payment_method != 'stripe')) {
    redirect('confirm_booking.php?id=' . $_SESSION['room']['id'] . '&currency=' . $selected_currency . '&error=invalid_payment');
  }

  // Save order data to the database
  $paramList = filteration($_POST);
  $query1 = "INSERT INTO `booking_order` (`user_id`, `room_id`, `check_in`, `check_out`, `order_id`, `trans_amt`, `currency`) VALUES (?,?,?,?,?,?,?)";
  insert($query1, [$CUST_ID, $_SESSION['room']['id'], $paramList['checkin'], $paramList['checkout'], $ORDER_ID, $final_amount, $final_currency], 'issssds');
  
  $booking_id = mysqli_insert_id($con);

  $query2 = "INSERT INTO `booking_details` (`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";
  insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $final_amount, $paramList['name'], $paramList['phonenum'], $paramList['address']], 'issssss');

  if ($payment_method === 'stripe') {
    // Stripe Payment
    $converted_amount = $final_amount;
    $checkoutSession = \Stripe\Checkout\Session::create([
      'payment_method_types' => ['card'],
      'line_items' => [
        [
          'price_data' => [
            'currency' => $selected_currency,
            'product_data' => [
              'name' => $_SESSION['room']['name'],
            ],
            'unit_amount' => $converted_amount * 100, // Stripe expects amount in cents
          ],
          'quantity' => 1,
        ],
      ],
      'mode' => 'payment',
      'client_reference_id' => $ORDER_ID,
      'success_url' => 'http://localhost/NepalNivas/pay_response.php?session_id={CHECKOUT_SESSION_ID}',
      'cancel_url' => 'http://localhost/NepalNivas/pay_status.php?status=failed',
    ]);

    header("Location: " . $checkoutSession->url);
    exit();
  } elseif ($payment_method === 'eSewa') {
    // eSewa Payment
    header("Location: esewa_payment.php?order_id=$ORDER_ID&amount=$TXN_AMOUNT");
    exit();
  }
}
?>