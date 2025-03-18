<?php
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');

session_start();

if (!isset($_GET['order']) || empty($_GET['order'])) {
    redirect('index.php');
}

$order_id = $_GET['order'];

// Fetch booking details from the database
$query = "SELECT bo.*, bd.* FROM `booking_order` bo 
          JOIN `booking_details` bd ON bo.booking_id = bd.booking_id 
          WHERE bo.order_id = ?";
$res = select($query, [$order_id], 's');

if (mysqli_num_rows($res) == 0) {
    redirect('index.php');
}
