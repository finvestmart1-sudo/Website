<?php
session_start();
if (!isset($_SESSION["user_id"]) || empty($_SESSION["is_admin"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payouts – Finvestmart Admin</title>
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
      <a href="analytics.php" class="admin-nav-link"><i class="fas fa-chart-bar"></i> Analytics</a>

      <div class="admin-nav-section">Management</div>
      <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> Users</a>
      <a href="applications.php" class="admin-nav-link"><i class="fas fa-file-alt"></i> Applications</a>
      <a href="rewards.php" class="admin-nav-link"><i class="fas fa-coins"></i> Rewards</a>
      <a href="partners.php" class="admin-nav-link"><i class="fas fa-handshake"></i> Partners</a>

      <div class="admin-nav-section">Finance</div>
      <a href="payouts.php" class="admin-nav-link active"><i class="fas fa-university"></i> Payouts</a>
      <a href="transactions.php" class="admin-nav-link"><i class="fas fa-exchange-alt"></i> Transactions</a>

      <div class="admin-nav-section">System</div>
      <a href="settings.php" class="admin-nav-link"><i class="fas fa-cog"></i> Settings</a>
      <a href="../api/auth/logout.php" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>

  <div class="admin-main">
    <div class="admin-topbar">
      <h1>Payouts</h1>
      <div style="display:flex;gap:12px;align-items:center;">
        <select style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
          <option>All Status</option><option>Pending</option><option>Processing</option><option>Completed</option><option>Failed</option>
        </select>
        <button class="btn btn-accent btn-sm" onclick="processBulk()"><i class="fas fa-bolt"></i> Process Pending</button>
      </div>
    </div>

    <div class="admin-content">
      <div class="admin-stats">
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Total Paid Out</span><div class="stat-card-icon" style="background:rgba(0,200,150,0.1);color:var(--accent-color);"><i class="fas fa-check-double"></i></div></div><div class="stat-card-value">₹2.5Cr</div><div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +₹18.5L this month</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Pending Payouts</span><div class="stat-card-icon" style="background:rgba(245,158,11,0.1);color:#F59E0B;"><i class="fas fa-clock"></i></div></div><div class="stat-card-value">₹4.2L</div><div class="stat-card-change" style="color:#F59E0B;">128 requests</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Processing</span><div class="stat-card-icon" style="background:rgba(99,102,241,0.1);color:#6366F1;"><i class="fas fa-spinner"></i></div></div><div class="stat-card-value">₹82K</div><div class="stat-card-change" style="color:#6366F1;">18 requests</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Failed (Today)</span><div class="stat-card-icon" style="background:rgba(239,68,68,0.1);color:#EF4444;"><i class="fas fa-times-circle"></i></div></div><div class="stat-card-value">3</div><div class="stat-card-change" style="color:#EF4444;">Need attention</div></div>
      </div>

      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;"><h3>Payout Requests</h3></div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead>
              <tr><th>Payout ID</th><th>User</th><th>Amount</th><th>Method</th><th>Account Details</th><th>Requested</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
              <?php
              $payouts = [
                ['PAY001','Amit Verma','₹700','UPI','amit@upi','22 Jan 2024','pending'],
                ['PAY002','Priya Nair','₹1,500','Bank Transfer','HDFC ****1234','15 Jan 2024','pending'],
                ['PAY003','Vikram Singh','₹4,000','Bank Transfer','SBI ****5678','23 Jan 2024','processing'],
                ['PAY004','Rahul Sharma','₹3,000','UPI','rahul@gpay','18 Jan 2024','processing'],
                ['PAY005','Meera Reddy','₹2,000','Bank Transfer','AXIS ****3456','24 Jan 2024','pending'],
                ['PAY006','Sunita Patel','₹5,000','Bank Transfer','HDFC ****7890','22 Jan 2024','completed'],
                ['PAY007','Kiran Kumar','₹800','UPI','kiran@upi','10 Jan 2024','completed'],
                ['PAY008','Deepa Menon','₹1,200','Bank Transfer','ICICI ****2345','08 Jan 2024','failed'],
              ];
              foreach ($payouts as $p): ?>
              <tr>
                <td><span style="font-family:monospace;font-size:0.75rem;color:var(--secondary-text);"><?= $p[0] ?></span></td>
                <td><strong><?= $p[1] ?></strong></td>
                <td style="color:var(--accent-color);font-weight:700;font-size:1rem;"><?= $p[2] ?></td>
                <td><span style="background:rgba(10,37,64,0.06);padding:2px 8px;border-radius:12px;font-size:0.75rem;"><?= $p[3] ?></span></td>
                <td style="font-size:0.8rem;color:var(--secondary-text);"><?= $p[4] ?></td>
                <td style="font-size:0.8rem;color:var(--secondary-text);"><?= $p[5] ?></td>
                <td>
                  <span class="status-badge <?= $p[6] === 'completed' ? 'approved' : ($p[6] === 'failed' ? 'rejected' : ($p[6] === 'processing' ? 'processing' : 'pending')) ?>"><?= ucfirst($p[6]) ?></span>
                </td>
                <td>
                  <?php if ($p[6] === 'pending'): ?>
                  <button onclick="processPayout('<?= $p[0] ?>')" style="background:var(--accent-color);color:#fff;border:none;padding:5px 12px;border-radius:6px;font-size:0.75rem;font-weight:600;cursor:pointer;"><i class="fas fa-paper-plane"></i> Pay</button>
                  <?php elseif ($p[6] === 'failed'): ?>
                  <button onclick="retryPayout('<?= $p[0] ?>')" style="background:rgba(239,68,68,0.1);color:#EF4444;border:none;padding:5px 12px;border-radius:6px;font-size:0.75rem;font-weight:600;cursor:pointer;"><i class="fas fa-redo"></i> Retry</button>
                  <?php elseif ($p[6] === 'completed'): ?>
                  <span style="color:var(--accent-color);font-size:0.75rem;font-weight:600;"><i class="fas fa-check"></i> Done</span>
                  <?php else: ?>
                  <span style="color:#6366F1;font-size:0.75rem;"><i class="fas fa-spinner fa-spin"></i> Processing</span>
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
    function processPayout(id) {
      if (confirm('Process this payout now?')) {
        if (window.showToast) showToast('Payout initiated for ' + id, 'success');
      }
    }
    function retryPayout(id) {
      if (confirm('Retry this failed payout?')) {
        if (window.showToast) showToast('Retrying payout ' + id, 'info');
      }
    }
    function processBulk() {
      if (confirm('Process all pending payouts?')) {
        if (window.showToast) showToast('Processing all pending payouts...', 'success');
      }
    }
  </script>
</body>
</html>
