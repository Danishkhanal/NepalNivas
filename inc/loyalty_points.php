<?php
// Function to get user's loyalty points balance
function getLoyaltyPointsBalance($user_id) {
    $query = "SELECT points_balance FROM loyalty_points WHERE user_id = ?";
    $values = [$user_id];
    $result = select($query, $values, 'i');
    
    if($row = mysqli_fetch_assoc($result)) {
        return $row['points_balance'];
    }
    
    // If no record exists, create one with 0 points
    $query = "INSERT INTO loyalty_points (user_id, points_balance) VALUES (?, 0)";
    insert($query, $values, 'i');
    return 0;
}

// Function to add points for a booking
function addLoyaltyPoints($user_id, $booking_id, $amount) {
    // Calculate points (1 point per $10 spent)
    $points = floor($amount / 10);
    
    if($points <= 0) return false;
    
    // Start transaction
    $con = $GLOBALS['con'];
    mysqli_begin_transaction($con);
    
    try {
        // Add points to user's balance
        $query = "INSERT INTO loyalty_points (user_id, points_balance) 
                 VALUES (?, ?) 
                 ON DUPLICATE KEY UPDATE points_balance = points_balance + ?";
        $values = [$user_id, $points, $points];
        insert($query, $values, 'iii');
        
        // Record the transaction
        $query = "INSERT INTO loyalty_transactions (user_id, points, type, description, booking_id) 
                 VALUES (?, ?, 'earn', 'Points earned from booking', ?)";
        $values = [$user_id, $points, $booking_id];
        insert($query, $values, 'iii');
        
        mysqli_commit($con);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($con);
        return false;
    }
}

// Function to redeem points for a reward
function redeemLoyaltyPoints($user_id, $reward_id) {
    // Get reward details
    $query = "SELECT * FROM loyalty_rewards WHERE id = ? AND is_active = 1";
    $values = [$reward_id];
    $result = select($query, $values, 'i');
    
    if(!($reward = mysqli_fetch_assoc($result))) {
        return ['success' => false, 'message' => 'Invalid reward'];
    }
    
    // Check if user has enough points
    $current_points = getLoyaltyPointsBalance($user_id);
    if($current_points < $reward['points_required']) {
        return ['success' => false, 'message' => 'Insufficient points'];
    }
    
    // Start transaction
    $con = $GLOBALS['con'];
    mysqli_begin_transaction($con);
    
    try {
        // Deduct points from user's balance
        $query = "UPDATE loyalty_points 
                 SET points_balance = points_balance - ? 
                 WHERE user_id = ?";
        $values = [$reward['points_required'], $user_id];
        update($query, $values, 'ii');
        
        // Record the transaction
        $query = "INSERT INTO loyalty_transactions (user_id, points, type, description) 
                 VALUES (?, ?, 'redeem', ?)";
        $values = [$user_id, $reward['points_required'], 'Redeemed ' . $reward['name']];
        insert($query, $values, 'iis');
        
        mysqli_commit($con);
        return [
            'success' => true, 
            'message' => 'Points redeemed successfully',
            'discount_percent' => $reward['discount_percent']
        ];
    } catch (Exception $e) {
        mysqli_rollback($con);
        return ['success' => false, 'message' => 'Failed to redeem points'];
    }
}

// Function to get available rewards
function getAvailableRewards() {
    $query = "SELECT * FROM loyalty_rewards WHERE is_active = 1 ORDER BY points_required ASC";
    return selectAll('loyalty_rewards');
}

// Function to get user's transaction history
function getLoyaltyTransactions($user_id) {
    $query = "SELECT * FROM loyalty_transactions WHERE user_id = ? ORDER BY created_at DESC";
    $values = [$user_id];
    return select($query, $values, 'i');
}
?> 