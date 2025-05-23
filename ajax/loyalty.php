<?php
require_once('../admin/inc/db_config.php');
require_once('../inc/loyalty_points.php');

session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

if(isset($_POST['redeem_points'])) {
    $reward_id = filteration($_POST['redeem_points']);
    $user_id = $_SESSION['uId'];
    
    $result = redeemLoyaltyPoints($user_id, $reward_id);
    echo json_encode($result);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?> 