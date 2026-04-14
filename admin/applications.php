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
  <title>Applications – Finvestmart Admin</title>
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
      <a href="applications.php" class="admin-nav-link active"><i class="fas fa-file-alt"></i> Applications</a>
      <a href="rewards.php" class="admin-nav-link"><i class="fas fa-coins"></i> Rewards</a>
      <a href="../api/auth/logout.php" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>
  <div class="admin-main">
    <div class="admin-topbar">
      <h1>Applications Management</h1>
      <div style="display:flex;gap:12px;">
        <select style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
          <option>All Products</option><option>Insurance</option><option>Personal Loan</option><option>Home Loan</option><option>Demat</option>
        </select>
        <select style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
          <option>All Status</option><option>Pending</option><option>Processing</option><option>Approved</option><option>Rejected</option>
        </select>
        <button class="btn btn-accent btn-sm"><i class="fas fa-download"></i> Export</button>
      </div>
    </div>
    <div class="admin-content">
      <div class="admin-stats">
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Total</span></div><div class="stat-card-value">4,891</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Pending</span></div><div class="stat-card-value" style="color:#F59E0B;">1,204</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Approved</span></div><div class="stat-card-value" style="color:var(--accent-color);">2,847</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Rejected</span></div><div class="stat-card-value" style="color:#EF4444;">840</div></div>
      </div>

      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;"><h3>All Applications</h3></div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead><tr><th>App ID</th><th>User</th><th>Product</th><th>Partner</th><th>Amount</th><th>Applied</th><th>Status</th><th>Reward</th><th>Actions</th></tr></thead>
            <tbody>
              <?php
              $apps = [
                ['#APP001','Rahul Sharma','Personal Loan','ICICI Bank','₹3,00,000','18 Jan 2024','processing','₹3,000'],
                ['#APP002','Priya Nair','Term Insurance','HDFC Life','₹1 Cr Cover','12 Jan 2024','approved','₹1,500'],
                ['#APP003','Amit Verma','Demat Account','Zerodha','—','20 Jan 2024','approved','₹700'],
                ['#APP004','Sunita Patel','Home Loan','SBI','₹35,00,000','22 Jan 2024','pending','₹5,000'],
                ['#APP005','Vikram Singh','Business Loan','Bajaj Finserv','₹10,00,000','23 Jan 2024','approved','₹4,000'],
                ['#APP006','Meera Reddy','Credit Card','HDFC Bank','—','24 Jan 2024','pending','₹2,000'],
                ['#APP007','Karan Mehta','Health Insurance','Max Life','₹10L Cover','25 Jan 2024','rejected','₹800'],
              ];
              foreach ($apps as $a): ?>
              <tr>
                <td><span style="font-family:monospace;font-size:0.75rem;"><?= $a[0] ?></span></td>
                <td><strong><?= $a[1] ?></strong></td>
                <td><?= $a[2] ?></td>
                <td><?= $a[3] ?></td>
                <td><?= $a[4] ?></td>
                <td style="color:var(--secondary-text);font-size:0.8rem;"><?= $a[5] ?></td>
                <td><span class="status-badge <?= $a[6] ?>"><?= ucfirst($a[6]) ?></span></td>
                <td style="color:var(--accent-color);font-weight:700;"><?= $a[7] ?></td>
                <td>
                  <div style="display:flex;gap:6px;">
                    <button style="background:rgba(0,200,150,0.1);color:var(--accent-color);border:none;padding:4px 8px;border-radius:6px;font-size:0.7rem;font-weight:600;cursor:pointer;">Approve</button>
                    <button style="background:rgba(239,68,68,0.1);color:#EF4444;border:none;padding:4px 8px;border-radius:6px;font-size:0.7rem;font-weight:600;cursor:pointer;">Reject</button>
                    <button style="background:rgba(10,37,64,0.06);color:var(--primary-color);border:none;padding:4px 8px;border-radius:6px;font-size:0.7rem;cursor:pointer;">View</button>
                  </div>
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
</body>
</html>
