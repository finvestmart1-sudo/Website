<?php
session_start();
if (!isset($_SESSION["user_id"]) || empty($_SESSION["is_admin"])) {
    header("Location: ../login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rewards Management – Finvestmart Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
</head>
<body style="background:var(--light-bg);">
  <aside class="admin-sidebar">
    <div class="admin-sidebar-logo"><div class="nav-logo-icon">F</div> Admin Panel</div>
    <nav class="admin-sidebar-nav">
      <div class="admin-nav-section">Dashboard</div>
      <a href="index.php" class="admin-nav-link"><i class="fas fa-home"></i> Overview</a>
      <div class="admin-nav-section">Management</div>
      <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> Users</a>
      <a href="applications.php" class="admin-nav-link"><i class="fas fa-file-alt"></i> Applications</a>
      <a href="rewards.php" class="admin-nav-link active"><i class="fas fa-coins"></i> Rewards</a>
      <a href="../api/auth/logout.php" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>
  <div class="admin-main">
    <div class="admin-topbar">
      <h1>Rewards Management</h1>
      <div style="display:flex;gap:12px;">
        <select style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
          <option>All Status</option><option>Pending Claim</option><option>Claimed</option><option>Paid</option>
        </select>
        <button class="btn btn-accent btn-sm" onclick="bulkPay()"><i class="fas fa-paper-plane"></i> Bulk Pay</button>
      </div>
    </div>
    <div class="admin-content">
      <div class="admin-stats">
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Total Rewards</span></div><div class="stat-card-value">₹2.5Cr</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Pending Payout</span></div><div class="stat-card-value" style="color:#F59E0B;">₹4.2L</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Paid This Month</span></div><div class="stat-card-value" style="color:var(--accent-color);">₹18.5L</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Avg Reward</span></div><div class="stat-card-value">₹2,430</div></div>
      </div>

      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;"><h3>Reward Claims</h3></div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead><tr><th><input type="checkbox" /></th><th>Reward ID</th><th>User</th><th>Product</th><th>Amount</th><th>Claim Date</th><th>Payout Method</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
              <?php
              $rewards = [
                ['RW001','Amit Verma','Demat – Zerodha','₹700','22 Jan 2024','UPI: amit@upi','claimed'],
                ['RW002','Priya Nair','Term Insurance – HDFC','₹1,500','15 Jan 2024','Bank: HDFC ****1234','claimed'],
                ['RW003','Vikram Singh','Business Loan – Bajaj','₹4,000','23 Jan 2024','Bank: SBI ****5678','claimed'],
                ['RW004','Rahul Sharma','Term Insurance – LIC','₹1,500','10 Dec 2023','UPI: rahul@upi','paid'],
                ['RW005','Sunita Patel','Home Loan – SBI','₹5,000','22 Jan 2024','Bank: AXIS ****9012','pending'],
              ];
              foreach ($rewards as $r): ?>
              <tr>
                <td><input type="checkbox" /></td>
                <td><span style="font-family:monospace;font-size:0.75rem;"><?= $r[0] ?></span></td>
                <td><strong><?= $r[1] ?></strong></td>
                <td><?= $r[2] ?></td>
                <td style="color:var(--accent-color);font-weight:700;"><?= $r[3] ?></td>
                <td style="color:var(--secondary-text);font-size:0.8rem;"><?= $r[4] ?></td>
                <td style="font-size:0.8rem;"><?= $r[5] ?></td>
                <td><span class="status-badge <?= $r[6] === 'paid' ? 'paid' : ($r[6] === 'claimed' ? 'approved' : 'pending') ?>"><?= ucfirst($r[6]) ?></span></td>
                <td>
                  <?php if ($r[6] === 'claimed'): ?>
                  <button onclick="payReward('<?= $r[0] ?>')" style="background:var(--accent-color);color:#fff;border:none;padding:6px 12px;border-radius:6px;font-size:0.75rem;font-weight:600;cursor:pointer;"><i class="fas fa-paper-plane"></i> Pay</button>
                  <?php elseif ($r[6] === 'paid'): ?>
                  <span style="color:var(--accent-color);font-size:0.75rem;font-weight:600;"><i class="fas fa-check"></i> Done</span>
                  <?php else: ?>
                  <span style="color:var(--secondary-text);font-size:0.75rem;">Waiting</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/js/main.js"></script>
  <script>
    function payReward(id) {
      if (confirm('Pay this reward now?')) {
        showToast('Reward payment initiated!', 'success');
      }
    }
    function bulkPay() {
      const checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
      if (checked > 0) {
        showToast(`Processing ${checked} reward payments...`, 'info');
      } else {
        showToast('Please select rewards to pay', 'error');
      }
    }
  </script>
</body>
</html>
