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
  <title>Users – Finvestmart Admin</title>
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
      <a href="users.php" class="admin-nav-link active"><i class="fas fa-users"></i> Users</a>
      <a href="applications.php" class="admin-nav-link"><i class="fas fa-file-alt"></i> Applications</a>
      <a href="rewards.php" class="admin-nav-link"><i class="fas fa-coins"></i> Rewards</a>
      <a href="../login.html" class="admin-nav-link" style="color:rgba(255,100,100,0.8);margin-top:auto;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>
  <div class="admin-main">
    <div class="admin-topbar">
      <h1>User Management</h1>
      <div style="display:flex;gap:12px;">
        <input type="search" placeholder="Search users..." style="padding:8px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;outline:none;width:240px;" />
        <button class="btn btn-accent btn-sm"><i class="fas fa-download"></i> Export</button>
      </div>
    </div>
    <div class="admin-content">
      <div class="admin-stats" style="grid-template-columns:repeat(4,1fr);">
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Total Users</span></div><div class="stat-card-value">10,284</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">Active</span></div><div class="stat-card-value">8,912</div><div class="stat-card-change positive">+128 this week</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">New (30 days)</span></div><div class="stat-card-value">642</div></div>
        <div class="stat-card"><div class="stat-card-header"><span class="stat-card-label">KYC Verified</span></div><div class="stat-card-value">7,841</div></div>
      </div>

      <div class="admin-table-card">
        <div class="card-header" style="padding:20px 24px;"><h3>All Users</h3></div>
        <div style="overflow-x:auto;">
          <table class="admin-table">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>City</th><th>Joined</th><th>Applications</th><th>Rewards</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
              <?php
              $users = [
                ['USR001','Rahul Sharma','rahul@example.com','9876543210','Bangalore','10 Jan 2024','5','₹8,750','active'],
                ['USR002','Priya Nair','priya@example.com','9876543211','Chennai','12 Jan 2024','3','₹1,500','active'],
                ['USR003','Amit Verma','amit@example.com','9876543212','Delhi','14 Jan 2024','2','₹700','active'],
                ['USR004','Sunita Patel','sunita@example.com','9876543213','Ahmedabad','15 Jan 2024','4','₹5,000','active'],
                ['USR005','Vikram Singh','vikram@example.com','9876543214','Mumbai','16 Jan 2024','1','₹4,000','active'],
                ['USR006','Meera Reddy','meera@example.com','9876543215','Hyderabad','17 Jan 2024','2','₹2,000','inactive'],
              ];
              foreach ($users as $u): ?>
              <tr>
                <td><span style="font-family:monospace;font-size:0.75rem;color:var(--secondary-text);"><?= $u[0] ?></span></td>
                <td><strong><?= $u[1] ?></strong></td>
                <td style="color:var(--secondary-text);font-size:0.8rem;"><?= $u[2] ?></td>
                <td><?= $u[3] ?></td>
                <td><?= $u[4] ?></td>
                <td style="color:var(--secondary-text);font-size:0.8rem;"><?= $u[5] ?></td>
                <td><?= $u[6] ?></td>
                <td style="color:var(--accent-color);font-weight:700;"><?= $u[7] ?></td>
                <td><span class="status-badge <?= $u[8] === 'active' ? 'approved' : 'pending' ?>"><?= ucfirst($u[8]) ?></span></td>
                <td>
                  <button style="background:rgba(10,37,64,0.06);color:var(--primary-color);border:none;padding:4px 10px;border-radius:6px;font-size:0.72rem;cursor:pointer;">View</button>
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
