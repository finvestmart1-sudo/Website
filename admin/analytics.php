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
  <title>Analytics – Finvestmart Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background:var(--light-bg);">

  <aside class="admin-sidebar">
    <div class="admin-sidebar-logo"><div class="nav-logo-icon">F</div> Admin Panel</div>
    <nav class="admin-sidebar-nav">
      <div class="admin-nav-section">Dashboard</div>
      <a href="index.php" class="admin-nav-link"><i class="fas fa-home"></i> Overview</a>
      <a href="analytics.php" class="admin-nav-link active"><i class="fas fa-chart-bar"></i> Analytics</a>

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
      <a href="../api/auth/logout.php" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>

  <div class="admin-main">
    <div class="admin-topbar">
      <h1>Analytics</h1>
      <div style="display:flex;align-items:center;gap:16px;">
        <select style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;">
          <option>Last 30 Days</option>
          <option>Last 90 Days</option>
          <option>This Year</option>
          <option>All Time</option>
        </select>
        <span style="font-size:0.825rem;color:var(--secondary-text);"><?= date('d M Y') ?></span>
      </div>
    </div>

    <div class="admin-content">

      <!-- Key Metrics -->
      <div class="admin-stats">
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">Total Revenue</span><div class="stat-card-icon" style="background:rgba(99,102,241,0.1);color:#6366F1;"><i class="fas fa-rupee-sign"></i></div></div>
          <div class="stat-card-value">₹2.5Cr</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +18.4% vs last month</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">Conversion Rate</span><div class="stat-card-icon" style="background:rgba(0,200,150,0.1);color:var(--accent-color);"><i class="fas fa-percentage"></i></div></div>
          <div class="stat-card-value">38.4%</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +2.1% vs last month</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">Avg. Order Value</span><div class="stat-card-icon" style="background:rgba(245,158,11,0.1);color:#F59E0B;"><i class="fas fa-chart-line"></i></div></div>
          <div class="stat-card-value">₹2,430</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +₹230 vs last month</div>
        </div>
        <div class="stat-card">
          <div class="stat-card-header"><span class="stat-card-label">New Signups</span><div class="stat-card-icon" style="background:rgba(10,37,64,0.08);color:var(--primary-color);"><i class="fas fa-user-plus"></i></div></div>
          <div class="stat-card-value">642</div>
          <div class="stat-card-change positive"><i class="fas fa-arrow-up"></i> +128 this week</div>
        </div>
      </div>

      <!-- Charts Row 1 -->
      <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:24px;">
        <div class="dashboard-card">
          <div class="card-header"><h3>Revenue Over Time</h3></div>
          <div class="card-body"><canvas id="revenueChart" height="120"></canvas></div>
        </div>
        <div class="dashboard-card">
          <div class="card-header"><h3>Product Mix</h3></div>
          <div class="card-body"><canvas id="productMixChart" height="120"></canvas></div>
        </div>
      </div>

      <!-- Charts Row 2 -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">
        <div class="dashboard-card">
          <div class="card-header"><h3>User Growth</h3></div>
          <div class="card-body"><canvas id="userGrowthChart" height="140"></canvas></div>
        </div>
        <div class="dashboard-card">
          <div class="card-header"><h3>Applications by City</h3></div>
          <div class="card-body">
            <table class="admin-table" style="margin-top:8px;">
              <thead><tr><th>City</th><th>Applications</th><th>Revenue</th><th>Share</th></tr></thead>
              <tbody>
                <?php
                $cities = [
                  ['Bangalore','1,242','₹42.1L','25.4%'],
                  ['Mumbai','1,018','₹38.6L','20.8%'],
                  ['Delhi','876','₹31.2L','17.9%'],
                  ['Chennai','654','₹22.4L','13.4%'],
                  ['Hyderabad','542','₹19.1L','11.1%'],
                  ['Ahmedabad','348','₹12.8L','7.1%'],
                  ['Others','211','₹11.3L','4.3%'],
                ];
                foreach ($cities as $c): ?>
                <tr>
                  <td><strong><?= $c[0] ?></strong></td>
                  <td><?= $c[1] ?></td>
                  <td style="color:var(--accent-color);font-weight:600;"><?= $c[2] ?></td>
                  <td><span style="background:rgba(0,200,150,0.1);color:var(--accent-color);padding:2px 8px;border-radius:12px;font-size:0.75rem;font-weight:600;"><?= $c[3] ?></span></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Funnel -->
      <div class="dashboard-card" style="margin-bottom:24px;">
        <div class="card-header"><h3>Conversion Funnel</h3></div>
        <div class="card-body">
          <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;padding:16px 0;">
            <?php
            $funnel = [
              ['Visitors','48,200','100%','#6366F1'],
              ['Signups','10,284','21.3%','#0A2540'],
              ['Applied','4,891','47.6%','#F59E0B'],
              ['Approved','3,124','63.9%','#00C896'],
              ['Rewarded','2,891','92.5%','#14B8A6'],
            ];
            foreach ($funnel as $f): ?>
            <div style="text-align:center;padding:20px;background:var(--light-bg);border-radius:12px;">
              <div style="font-size:1.6rem;font-weight:800;color:<?= $f[3] ?>;"><?= $f[1] ?></div>
              <div style="font-size:0.8rem;color:var(--secondary-text);margin:4px 0;"><?= $f[0] ?></div>
              <div style="font-size:0.75rem;font-weight:700;color:<?= $f[3] ?>;"><?= $f[2] ?></div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="../assets/js/main.js"></script>
  <script>
    // Revenue Chart
    new Chart(document.getElementById('revenueChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels: ['Aug','Sep','Oct','Nov','Dec','Jan'],
        datasets: [{
          label: 'Revenue (₹L)',
          data: [18.2, 22.4, 19.8, 28.6, 31.4, 38.2],
          backgroundColor: 'rgba(10,37,64,0.8)',
          borderRadius: 6
        },{
          label: 'Rewards Paid (₹L)',
          data: [4.1, 5.2, 4.8, 7.1, 8.4, 10.2],
          backgroundColor: 'rgba(0,200,150,0.8)',
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' } }, x: { grid: { display: false } } }
      }
    });

    // Product Mix
    new Chart(document.getElementById('productMixChart').getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: ['Insurance','Personal Loan','Home Loan','Demat','Credit Card','Business Loan'],
        datasets: [{ data: [28,24,18,14,10,6], backgroundColor: ['#0A2540','#00C896','#6366F1','#F59E0B','#EF4444','#14B8A6'], borderWidth: 0 }]
      },
      options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } } }
    });

    // User Growth
    new Chart(document.getElementById('userGrowthChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: ['Aug','Sep','Oct','Nov','Dec','Jan'],
        datasets: [{
          label: 'Total Users',
          data: [6200, 7100, 7900, 8600, 9400, 10284],
          borderColor: '#0A2540', backgroundColor: 'rgba(10,37,64,0.06)',
          borderWidth: 2, fill: true, tension: 0.4, pointBackgroundColor: '#0A2540', pointRadius: 4
        },{
          label: 'New Users',
          data: [420, 380, 510, 640, 580, 642],
          borderColor: '#00C896', backgroundColor: 'rgba(0,200,150,0.06)',
          borderWidth: 2, fill: true, tension: 0.4, pointBackgroundColor: '#00C896', pointRadius: 4
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: { y: { beginAtZero: false, grid: { color: 'rgba(0,0,0,0.04)' } }, x: { grid: { display: false } } }
      }
    });
  </script>
</body>
</html>
