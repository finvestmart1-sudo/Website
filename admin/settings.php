<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings – Finvestmart Admin</title>
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
      <a href="transactions.php" class="admin-nav-link"><i class="fas fa-exchange-alt"></i> Transactions</a>

      <div class="admin-nav-section">System</div>
      <a href="settings.php" class="admin-nav-link active"><i class="fas fa-cog"></i> Settings</a>
      <a href="../login.html" class="admin-nav-link" style="color:rgba(255,100,100,0.8);"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>
  </aside>

  <div class="admin-main">
    <div class="admin-topbar">
      <h1>Settings</h1>
      <button class="btn btn-accent btn-sm" onclick="saveSettings()"><i class="fas fa-save"></i> Save Changes</button>
    </div>

    <div class="admin-content">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

        <!-- General Settings -->
        <div class="dashboard-card">
          <div class="card-header"><h3><i class="fas fa-globe" style="color:var(--accent-color);margin-right:8px;"></i>General Settings</h3></div>
          <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Platform Name</label>
              <input type="text" value="Finvestmart" style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;" />
            </div>
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Support Email</label>
              <input type="email" value="support@finvestmart.com" style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;" />
            </div>
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Support Phone</label>
              <input type="text" value="+91 98765 43210" style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;" />
            </div>
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Default Currency</label>
              <select style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;">
                <option selected>INR (₹) – Indian Rupee</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Reward Settings -->
        <div class="dashboard-card">
          <div class="card-header"><h3><i class="fas fa-coins" style="color:var(--accent-color);margin-right:8px;"></i>Reward Settings</h3></div>
          <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Minimum Payout Amount</label>
              <input type="text" value="₹500" style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;" />
            </div>
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Payout Processing Time</label>
              <select style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;">
                <option>Instant (UPI)</option>
                <option selected>1-3 Business Days (Bank)</option>
                <option>Same Day</option>
              </select>
            </div>
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Auto-approve Rewards Below</label>
              <input type="text" value="₹1,000" style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;" />
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;background:var(--light-bg);border-radius:8px;">
              <div>
                <div style="font-size:0.85rem;font-weight:600;">Auto-pay Approved Rewards</div>
                <div style="font-size:0.75rem;color:var(--secondary-text);">Automatically process payouts when approved</div>
              </div>
              <label style="position:relative;display:inline-block;width:44px;height:24px;">
                <input type="checkbox" checked style="opacity:0;width:0;height:0;" />
                <span style="position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:var(--accent-color);border-radius:24px;transition:0.3s;"></span>
              </label>
            </div>
          </div>
        </div>

        <!-- Notification Settings -->
        <div class="dashboard-card">
          <div class="card-header"><h3><i class="fas fa-bell" style="color:var(--accent-color);margin-right:8px;"></i>Notifications</h3></div>
          <div class="card-body" style="display:flex;flex-direction:column;gap:12px;">
            <?php
            $notifications = [
              ['New User Registration', 'Send email when a new user signs up', true],
              ['Application Submitted', 'Alert when new application is received', true],
              ['Reward Claimed', 'Notify when user claims a reward', true],
              ['Payout Completed', 'Confirmation when payout is processed', true],
              ['Failed Payout Alert', 'Immediate alert on payout failure', true],
              ['Weekly Summary Report', 'Weekly analytics digest every Monday', false],
            ];
            foreach ($notifications as $n): ?>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;background:var(--light-bg);border-radius:8px;">
              <div>
                <div style="font-size:0.85rem;font-weight:600;"><?= $n[0] ?></div>
                <div style="font-size:0.75rem;color:var(--secondary-text);"><?= $n[1] ?></div>
              </div>
              <label style="position:relative;display:inline-block;width:44px;height:24px;flex-shrink:0;">
                <input type="checkbox" <?= $n[2] ? 'checked' : '' ?> style="opacity:0;width:0;height:0;" />
                <span style="position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:<?= $n[2] ? 'var(--accent-color)' : '#E5E7EB' ?>;border-radius:24px;transition:0.3s;"></span>
              </label>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Security Settings -->
        <div class="dashboard-card">
          <div class="card-header"><h3><i class="fas fa-shield-alt" style="color:var(--accent-color);margin-right:8px;"></i>Security</h3></div>
          <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Admin Email</label>
              <input type="email" value="admin@finvestmart.com" style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;" />
            </div>
            <div>
              <label style="font-size:0.85rem;font-weight:600;color:var(--primary-color);display:block;margin-bottom:6px;">Change Password</label>
              <input type="password" placeholder="New password..." style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;margin-bottom:8px;" />
              <input type="password" placeholder="Confirm new password..." style="width:100%;padding:10px 14px;border:1px solid var(--border-color);border-radius:8px;font-size:0.875rem;font-family:inherit;" />
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;background:var(--light-bg);border-radius:8px;">
              <div>
                <div style="font-size:0.85rem;font-weight:600;">Two-Factor Authentication</div>
                <div style="font-size:0.75rem;color:var(--secondary-text);">Require OTP for admin login</div>
              </div>
              <label style="position:relative;display:inline-block;width:44px;height:24px;">
                <input type="checkbox" style="opacity:0;width:0;height:0;" />
                <span style="position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:#E5E7EB;border-radius:24px;transition:0.3s;"></span>
              </label>
            </div>
            <div style="padding:12px;background:rgba(239,68,68,0.05);border:1px solid rgba(239,68,68,0.2);border-radius:8px;">
              <div style="font-size:0.85rem;font-weight:600;color:#EF4444;margin-bottom:4px;"><i class="fas fa-exclamation-triangle"></i> Danger Zone</div>
              <div style="font-size:0.75rem;color:var(--secondary-text);margin-bottom:10px;">These actions cannot be undone.</div>
              <button style="background:rgba(239,68,68,0.1);color:#EF4444;border:1px solid rgba(239,68,68,0.3);padding:6px 14px;border-radius:6px;font-size:0.8rem;font-weight:600;cursor:pointer;" onclick="if(confirm('Clear all sessions?')) showToast('All sessions cleared', 'success')">Clear All Sessions</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="../assets/js/main.js"></script>
  <script>
    function saveSettings() {
      if (window.showToast) showToast('Settings saved successfully!', 'success');
    }
  </script>
</body>
</html>
