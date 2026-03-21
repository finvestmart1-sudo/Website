<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Partners – Finvestmart Admin</title>
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
      <a href="partners.php" class="admin-nav-link active"><i class="fas fa-handshake"></i> Partners</a>

      <div class="admin-nav-section">Finance</div>
      <a href="payouts.php" class="admin-nav-link"><i class="fas fa-university"></i> Payouts</a>
      <a href="transactions.php" class="admin-nav-link"><i class="fas fa-exchange-alt"></i> Transactions</a>

      <div class="admin-nav-section">System</div>
      <a href="settings.php" class="admin-nav-link"><i class="fas fa-cog"></i> Settings</a>
      <a href="../login.html" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>

  <div class="admin-main">
    <div class="admin-topbar">
      <h1>Partner Management</h1>
      <div style="display:flex;gap:12px;">
        <input type="search" placeholder="Search partners..." style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;width:240px;" />
        <button class="btn btn-accent btn-sm"><i class="fas fa-plus"></i> Add Partner</button>
      </div>
    </div>

    <div class="admin-content">
      <div class="admin-stats">
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Total Partners</span><div class="stat-card-icon" style="background:rgba(99,102,241,0.1);color:#6366F1;"><i class="fas fa-handshake"></i></div></div><div class="stat-card-value">48</div><div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +3 this month</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Active Partners</span><div class="stat-card-icon" style="background:rgba(0,200,150,0.1);color:var(--accent-color);"><i class="fas fa-check-circle"></i></div></div><div class="stat-card-value">42</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Total Applications</span><div class="stat-card-icon" style="background:rgba(245,158,11,0.1);color:#F59E0B;"><i class="fas fa-file-alt"></i></div></div><div class="stat-card-value">4,891</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Commissions Paid</span><div class="stat-card-icon" style="background:rgba(10,37,64,0.08);color:var(--primary-color);"><i class="fas fa-rupee-sign"></i></div></div><div class="stat-card-value">₹1.8Cr</div></div>
      </div>

      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;"><h3>All Partners</h3></div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead>
              <tr><th>Partner ID</th><th>Name</th><th>Category</th><th>Commission Rate</th><th>Applications</th><th>Revenue</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
              <?php
              $partners = [
                ['PTR001','ICICI Bank','Personal Loan','2.5%','824','₹28.4L','active'],
                ['PTR002','HDFC Life','Insurance','3.0%','612','₹22.1L','active'],
                ['PTR003','SBI Home Loans','Home Loan','1.8%','384','₹18.6L','active'],
                ['PTR004','Zerodha','Demat Account','₹700 flat','542','₹3.8L','active'],
                ['PTR005','Bajaj Finserv','Business Loan','2.2%','318','₹14.2L','active'],
                ['PTR006','HDFC Bank','Credit Card','₹2,000 flat','486','₹9.7L','active'],
                ['PTR007','LIC India','Insurance','2.8%','294','₹11.4L','active'],
                ['PTR008','Axis Bank','Personal Loan','2.3%','218','₹8.1L','inactive'],
              ];
              foreach ($partners as $p): ?>
              <tr>
                <td><span style="font-family:monospace;font-size:0.75rem;color:var(--secondary-text);"><?= $p[0] ?></span></td>
                <td><strong><?= $p[1] ?></strong></td>
                <td><span style="background:rgba(99,102,241,0.1);color:#6366F1;padding:2px 8px;border-radius:12px;font-size:0.75rem;font-weight:600;"><?= $p[2] ?></span></td>
                <td style="font-weight:600;color:var(--accent-color);"><?= $p[3] ?></td>
                <td><?= $p[4] ?></td>
                <td style="color:var(--accent-color);font-weight:700;"><?= $p[5] ?></td>
                <td><span class="status-badge <?= $p[6] === 'active' ? 'approved' : 'pending' ?>"><?= ucfirst($p[6]) ?></span></td>
                <td>
                  <div style="display:flex;gap:6px;">
                    <button style="background:rgba(10,37,64,0.06);color:var(--primary-color);border:none;padding:4px 10px;border-radius:6px;font-size:0.72rem;cursor:pointer;"><i class="fas fa-eye"></i> View</button>
                    <button style="background:rgba(0,200,150,0.1);color:var(--accent-color);border:none;padding:4px 10px;border-radius:6px;font-size:0.72rem;cursor:pointer;"><i class="fas fa-edit"></i> Edit</button>
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
