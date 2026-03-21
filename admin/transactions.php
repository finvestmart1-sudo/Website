<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transactions – Finvestmart Admin</title>
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
      <a href="payouts.php" class="admin-nav-link"><i class="fas fa-university"></i> Payouts</a>
      <a href="transactions.php" class="admin-nav-link active"><i class="fas fa-exchange-alt"></i> Transactions</a>

      <div class="admin-nav-section">System</div>
      <a href="settings.php" class="admin-nav-link"><i class="fas fa-cog"></i> Settings</a>
      <a href="../login.html" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>

  <div class="admin-main">
    <div class="admin-topbar">
      <h1>Transactions</h1>
      <div style="display:flex;gap:12px;align-items:center;">
        <input type="search" placeholder="Search transactions..." style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;width:240px;" />
        <select style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
          <option>All Types</option><option>Reward Credit</option><option>Payout Debit</option><option>Refund</option>
        </select>
        <button class="btn btn-accent btn-sm"><i class="fas fa-download"></i> Export CSV</button>
      </div>
    </div>

    <div class="admin-content">
      <div class="admin-stats">
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Total Volume</span><div class="stat-card-icon" style="background:rgba(99,102,241,0.1);color:#6366F1;"><i class="fas fa-exchange-alt"></i></div></div><div class="stat-card-value">₹4.8Cr</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Credits (Rewards)</span><div class="stat-card-icon" style="background:rgba(0,200,150,0.1);color:var(--accent-color);"><i class="fas fa-arrow-down"></i></div></div><div class="stat-card-value">₹2.5Cr</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Debits (Payouts)</span><div class="stat-card-icon" style="background:rgba(245,158,11,0.1);color:#F59E0B;"><i class="fas fa-arrow-up"></i></div></div><div class="stat-card-value">₹2.1Cr</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Net Balance</span><div class="stat-card-icon" style="background:rgba(10,37,64,0.08);color:var(--primary-color);"><i class="fas fa-wallet"></i></div></div><div class="stat-card-value">₹42.6L</div></div>
      </div>

      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;"><h3>Transaction Ledger</h3></div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead>
              <tr><th>TXN ID</th><th>Date & Time</th><th>User</th><th>Type</th><th>Description</th><th>Amount</th><th>Status</th><th>Reference</th></tr>
            </thead>
            <tbody>
              <?php
              $transactions = [
                ['TXN2401001','24 Jan 2024, 14:32','Amit Verma','credit','Demat Account Reward – Zerodha','+ ₹700','completed','APP003'],
                ['TXN2401002','24 Jan 2024, 13:18','Priya Nair','debit','Reward Payout – UPI','- ₹1,500','completed','RW002'],
                ['TXN2401003','23 Jan 2024, 16:42','Vikram Singh','credit','Business Loan Reward – Bajaj','+ ₹4,000','completed','APP005'],
                ['TXN2401004','23 Jan 2024, 11:05','Meera Reddy','credit','Credit Card Reward – HDFC','+ ₹2,000','pending','APP006'],
                ['TXN2401005','22 Jan 2024, 09:28','Sunita Patel','debit','Reward Payout – Bank Transfer','- ₹5,000','completed','RW005'],
                ['TXN2401006','20 Jan 2024, 18:14','Amit Verma','credit','Demat Account Bonus','+ ₹200','completed','BONUS001'],
                ['TXN2401007','18 Jan 2024, 10:32','Rahul Sharma','credit','Personal Loan Reward – ICICI','+ ₹3,000','processing','APP001'],
                ['TXN2401008','15 Jan 2024, 15:44','Priya Nair','credit','Term Insurance Reward – HDFC Life','+ ₹1,500','completed','APP002'],
                ['TXN2401009','12 Jan 2024, 12:21','Kiran Kumar','debit','Reward Payout – UPI','- ₹800','completed','RW007'],
                ['TXN2401010','08 Jan 2024, 08:55','Deepa Menon','debit','Reward Payout – Bank Transfer','- ₹1,200','failed','RW008'],
              ];
              foreach ($transactions as $t):
                $isCredit = $t[3] === 'credit';
              ?>
              <tr>
                <td><span style="font-family:monospace;font-size:0.72rem;color:var(--secondary-text);"><?= $t[0] ?></span></td>
                <td style="font-size:0.8rem;color:var(--secondary-text);"><?= $t[1] ?></td>
                <td><strong><?= $t[2] ?></strong></td>
                <td>
                  <span style="background:<?= $isCredit ? 'rgba(0,200,150,0.1)' : 'rgba(245,158,11,0.1)' ?>;color:<?= $isCredit ? 'var(--accent-color)' : '#F59E0B' ?>;padding:2px 8px;border-radius:12px;font-size:0.72rem;font-weight:600;">
                    <i class="fas fa-<?= $isCredit ? 'arrow-down' : 'arrow-up' ?>"></i> <?= ucfirst($t[3]) ?>
                  </span>
                </td>
                <td style="font-size:0.82rem;"><?= $t[4] ?></td>
                <td style="font-weight:700;color:<?= $isCredit ? 'var(--accent-color)' : '#F59E0B' ?>;font-size:0.95rem;"><?= $t[5] ?></td>
                <td><span class="status-badge <?= $t[6] === 'completed' ? 'approved' : ($t[6] === 'failed' ? 'rejected' : 'processing') ?>"><?= ucfirst($t[6]) ?></span></td>
                <td><span style="font-family:monospace;font-size:0.72rem;background:rgba(10,37,64,0.05);padding:2px 6px;border-radius:4px;"><?= $t[7] ?></span></td>
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
