<?php
session_start();
// In production, check admin login: if (!isset($_SESSION['admin_id'])) { header('Location: ../login.html'); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard – Finvestmart</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background:var(--light-bg);">

  <!-- Admin Sidebar -->
  <aside class="admin-sidebar">
    <div class="admin-sidebar-logo">
      <div class="nav-logo-icon">F</div>
      Admin Panel
    </div>
    <nav class="admin-sidebar-nav">
      <div class="admin-nav-section">Dashboard</div>
      <a href="index.php" class="admin-nav-link active"><i class="fas fa-home"></i> Overview</a>
      <a href="analytics.php" class="admin-nav-link"><i class="fas fa-chart-bar"></i> Analytics</a>

      <div class="admin-nav-section">Management</div>
      <a href="users.php" class="admin-nav-link"><i class="fas fa-users"></i> Users</a>
      <a href="applications.php" class="admin-nav-link"><i class="fas fa-file-alt"></i> Applications</a>
      <a href="rewards.php" class="admin-nav-link"><i class="fas fa-coins"></i> Rewards</a>
      <a href="partners.php" class="admin-nav-link"><i class="fas fa-handshake"></i> Partners</a>

      <div class="admin-nav-section">Finance</div>
      <a href="payouts.php" class="admin-nav-link"><i class="fas fa-university"></i> Payouts</a>
      <a href="transactions.php" class="admin-nav-link"><i class="fas fa-exchange-alt"></i> Transactions</a>

      <div class="admin-nav-section">System</div>
      <a href="settings.php" class="admin-nav-link"><i class="fas fa-cog"></i> Settings</a>
      <a href="../login.html" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>

  <!-- Admin Main -->
  <div class="admin-main">
    <!-- Top Bar -->
    <div class="admin-topbar">
      <h1>Dashboard Overview</h1>
      <div style="display:flex;align-items:center;gap:16px;">
        <span style="font-size:0.825rem;color:var(--secondary-text);"><?= date('d M Y, H:i') ?></span>
        <div style="display:flex;align-items:center;gap:8px;">
          <div style="width:34px;height:34px;background:var(--accent-color);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.8rem;font-weight:700;">A</div>
          <span style="font-size:0.875rem;font-weight:600;">Admin</span>
        </div>
      </div>
    </div>

    <div class="admin-content">

      <!-- Stats -->
      <div class="admin-stats">
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">Total Users</span><div class="stat-card-icon" style="background:rgba(99,102,241,0.1);color:#6366F1;"><i class="fas fa-users"></i></div></div>
          <div class="stat-card-value">10,284</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +128 this week</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">Applications</span><div class="stat-card-icon" style="background:rgba(245,158,11,0.1);color:#F59E0B;"><i class="fas fa-file-alt"></i></div></div>
          <div class="stat-card-value">4,891</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +67 today</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">Rewards Paid</span><div class="stat-card-icon" style="background:rgba(0,200,150,0.1);color:var(--accent-color);"><i class="fas fa-coins"></i></div></div>
          <div class="stat-card-value">₹2.5Cr</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +₹1.8L today</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">Conversion Rate</span><div class="stat-card-icon" style="background:rgba(10,37,64,0.08);color:var(--primary-color);"><i class="fas fa-percentage"></i></div></div>
          <div class="stat-card-value">38.4%</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +2.1% vs last month</div>
        </div>
      </div>

      <!-- Charts Row -->
      <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:24px;">
        <div class="dashboard-card">
          <div class="card-header"><h3>Applications This Month</h3></div>
          <div class="card-body">
            <canvas id="applicationsChart" height="120"></canvas>
          </div>
        </div>
        <div class="dashboard-card">
          <div class="card-header"><h3>Product Distribution</h3></div>
          <div class="card-body">
            <canvas id="productChart" height="120"></canvas>
          </div>
        </div>
      </div>

      <!-- Recent Applications Table -->
      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;">
          <h3>Recent Applications</h3>
          <a href="applications.php" style="font-size:0.8rem;color:var(--accent-color);font-weight:600;">View All</a>
        </div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead>
              <tr>
                <th>ID</th><th>User</th><th>Product</th><th>Partner</th>
                <th>Amount</th><th>Date</th><th>Status</th><th>Reward</th><th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $applications = [
                ['#APP001','Rahul Sharma','Personal Loan','ICICI Bank','₹3,00,000','18 Jan 2024','processing','₹3,000'],
                ['#APP002','Priya Nair','Term Insurance','HDFC Life','₹1 Cr Cover','12 Jan 2024','approved','₹1,500'],
                ['#APP003','Amit Verma','Demat Account','Zerodha','—','20 Jan 2024','approved','₹700'],
                ['#APP004','Sunita Patel','Home Loan','SBI','₹35,00,000','22 Jan 2024','pending','₹5,000'],
                ['#APP005','Vikram Singh','Business Loan','Bajaj Finserv','₹10,00,000','23 Jan 2024','approved','₹4,000'],
                ['#APP006','Meera Reddy','Credit Card','HDFC Bank','—','24 Jan 2024','pending','₹2,000'],
              ];
              foreach ($applications as $app): ?>
              <tr>
                <td><span style="font-family:monospace;font-size:0.8rem;"><?= $app[0] ?></span></td>
                <td><strong><?= $app[1] ?></strong></td>
                <td><?= $app[2] ?></td>
                <td><?= $app[3] ?></td>
                <td><?= $app[4] ?></td>
                <td style="color:var(--secondary-text);font-size:0.8rem;"><?= $app[5] ?></td>
                <td>
                  <span class="status-badge <?= $app[6] ?>"><?= ucfirst($app[6]) ?></span>
                </td>
                <td style="color:var(--accent-color);font-weight:700;"><?= $app[7] ?></td>
                <td>
                  <div style="display:flex;gap:6px;">
                    <button onclick="updateStatus('<?= $app[0] ?>','approved')" style="background:rgba(0,200,150,0.1);color:var(--accent-color);border:none;padding:4px 10px;border-radius:6px;font-size:0.72rem;font-weight:600;cursor:pointer;">Approve</button>
                    <button onclick="updateStatus('<?= $app[0] ?>','rejected')" style="background:rgba(239,68,68,0.1);color:#EF4444;border:none;padding:4px 10px;border-radius:6px;font-size:0.72rem;font-weight:600;cursor:pointer;">Reject</button>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pending Rewards Table -->
      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;">
          <h3>Pending Reward Approvals</h3>
          <a href="rewards.php" style="font-size:0.8rem;color:var(--accent-color);font-weight:600;">View All</a>
        </div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead>
              <tr><th>User</th><th>Product</th><th>Reward</th><th>Claim Date</th><th>Bank/UPI</th><th>Action</th></tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>Amit Verma</strong></td>
                <td>Demat Account – Zerodha</td>
                <td style="color:var(--accent-color);font-weight:700;">₹700</td>
                <td>22 Jan 2024</td>
                <td>UPI: amit@upi</td>
                <td>
                  <button onclick="payReward('RW001')" style="background:var(--accent-color);color:#fff;border:none;padding:6px 14px;border-radius:8px;font-size:0.8rem;font-weight:600;cursor:pointer;"><i class="fas fa-paper-plane"></i> Pay Now</button>
                </td>
              </tr>
              <tr>
                <td><strong>Priya Nair</strong></td>
                <td>Term Insurance – HDFC Life</td>
                <td style="color:var(--accent-color);font-weight:700;">₹1,500</td>
                <td>15 Jan 2024</td>
                <td>Bank: HDFC ****1234</td>
                <td>
                  <button onclick="payReward('RW002')" style="background:var(--accent-color);color:#fff;border:none;padding:6px 14px;border-radius:8px;font-size:0.8rem;font-weight:600;cursor:pointer;"><i class="fas fa-paper-plane"></i> Pay Now</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

  <script src="../assets/js/main.js"></script>
  <script>
    // Applications Chart
    const ctx1 = document.getElementById('applicationsChart').getContext('2d');
    new Chart(ctx1, {
      type: 'line',
      data: {
        labels: ['1 Jan','5 Jan','10 Jan','15 Jan','20 Jan','25 Jan','30 Jan'],
        datasets: [{
          label: 'Applications',
          data: [45, 72, 58, 91, 87, 104, 118],
          borderColor: '#0A2540',
          backgroundColor: 'rgba(10,37,64,0.05)',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#0A2540',
          pointRadius: 4
        },{
          label: 'Approved',
          data: [28, 45, 32, 60, 54, 72, 85],
          borderColor: '#00C896',
          backgroundColor: 'rgba(0,200,150,0.05)',
          borderWidth: 2,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#00C896',
          pointRadius: 4
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' } }, x: { grid: { display: false } } }
      }
    });

    // Product Distribution Chart
    const ctx2 = document.getElementById('productChart').getContext('2d');
    new Chart(ctx2, {
      type: 'doughnut',
      data: {
        labels: ['Insurance', 'Personal Loan', 'Home Loan', 'Demat', 'Credit Card', 'Business Loan'],
        datasets: [{
          data: [28, 24, 18, 14, 10, 6],
          backgroundColor: ['#0A2540','#00C896','#6366F1','#F59E0B','#EF4444','#14B8A6'],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
      }
    });

    function updateStatus(appId, status) {
      fetch('../api/admin/update-application.php', {
        method: 'POST',
        body: new URLSearchParams({ app_id: appId, status: status })
      }).then(r => r.json()).then(d => {
        if (d.success) {
          if (window.showToast) showToast(`Application ${status} successfully!`, 'success');
          setTimeout(() => location.reload(), 1500);
        }
      });
    }

    function payReward(rewardId) {
      if (!confirm('Confirm reward payout?')) return;
      fetch('../api/admin/pay-reward.php', {
        method: 'POST',
        body: new URLSearchParams({ reward_id: rewardId })
      }).then(r => r.json()).then(d => {
        if (d.success) {
          if (window.showToast) showToast('Reward paid successfully!', 'success');
          setTimeout(() => location.reload(), 1500);
        }
      });
    }
  </script>
</body>
</html>
