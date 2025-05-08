<?php
require('../admin/inc/db_config.php');

function fetchExchangeRates() {
    $api_key = '76f54876e1914127b401c01cb75c2af9'; // Replace with your actual API key
    $url = "https://openexchangerates.org/api/latest.json?app_id=$api_key";
    $response = file_get_contents($url);
    return json_decode($response, true)['rates'];
}

function updateExchangeRates($rates, $con) {
    $current_time = date('Y-m-d H:i:s');
    foreach ($rates as $currency => $rate) {
        $query = "INSERT INTO `exchange_rates` (`currency`, `rate`, `last_updated`)
                  VALUES (?, ?, ?)
                  ON DUPLICATE KEY UPDATE `rate` = VALUES(`rate`), `last_updated` = VALUES(`last_updated`)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('sds', $currency, $rate, $current_time);
        $stmt->execute();
    }
}

$rates = fetchExchangeRates();
updateExchangeRates($rates, $con);
echo "Exchange rates updated successfully.";
?>