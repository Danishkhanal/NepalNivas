<?php
require('inc/links.php');
require('inc/header.php');
require_once('inc/loyalty_points.php');

// Check if user is logged in
if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
  redirect('index.php');
}

$user_id = $_SESSION['uId'];
$points_balance = getLoyaltyPointsBalance($user_id);
$rewards = getAvailableRewards();
$transactions = getLoyaltyTransactions($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Loyalty Program - <?php echo $settings_r['site_title'] ?></title>
</head>
<body class="bg-light">
  <div class="container">
    <div class="row">
      <div class="col-12 my-5 mb-4 px-4">
        <h2 class="fw-bold">Loyalty Program</h2>
        <div style="font-size: 14px;">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="#" class="text-secondary text-decoration-none">LOYALTY PROGRAM</a>
        </div>
      </div>

      <!-- Points Balance Card -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center">
            <h5 class="card-title">Your Points Balance</h5>
            <h2 class="text-primary mb-3"><?php echo $points_balance; ?></h2>
            <p class="text-muted">Earn 1 point for every NPR 10 spent</p>
          </div>
        </div>
      </div>

      <!-- Available Rewards -->
      <div class="col-lg-8 col-md-6 mb-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-4">Available Rewards</h5>
            <div class="row">
              <?php while($reward = mysqli_fetch_assoc($rewards)): ?>
                <div class="col-md-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h6 class="card-title"><?php echo $reward['name']; ?></h6>
                      <p class="card-text"><?php echo $reward['description']; ?></p>
                      <p class="text-primary mb-3"><?php echo $reward['points_required']; ?> points required</p>
                      <?php if($points_balance >= $reward['points_required']): ?>
                        <button class="btn btn-primary btn-sm" onclick="redeemPoints(<?php echo $reward['id']; ?>)">
                          Redeem Now
                        </button>
                      <?php else: ?>
                        <button class="btn btn-secondary btn-sm" disabled>
                          Not Enough Points
                        </button>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Transaction History -->
      <div class="col-12 mb-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="card-title mb-4">Transaction History</h5>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Points</th>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($transaction = mysqli_fetch_assoc($transactions)): ?>
                    <tr>
                      <td><?php echo date('M d, Y', strtotime($transaction['created_at'])); ?></td>
                      <td>
                        <span class="badge <?php echo $transaction['type'] == 'earn' ? 'bg-success' : 'bg-warning'; ?>">
                          <?php echo ucfirst($transaction['type']); ?>
                        </span>
                      </td>
                      <td><?php echo $transaction['points']; ?></td>
                      <td><?php echo $transaction['description']; ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php require('inc/footer.php'); ?>

  <script>
    function redeemPoints(rewardId) {
      if(confirm('Are you sure you want to redeem your points for this reward?')) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/loyalty.php", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
          let data = JSON.parse(this.responseText);
          if(data.success) {
            alert('success', data.message);
            window.location.reload();
          } else {
            alert('error', data.message);
          }
        }
        
        xhr.send('redeem_points=' + rewardId);
      }
    }
  </script>
</body>
</html> 