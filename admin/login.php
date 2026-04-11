<?php
/**
 * FINVESTMART - ADMIN LOGIN
 */
session_start();
// Already logged in as admin
if (!empty($_SESSION['is_admin'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/database.php';

    $email    = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        try {
            $db   = getDB();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND is_admin = 1 LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                if ($user['status'] === 'blocked') {
                    $error = 'Your admin account is blocked. Contact support.';
                } else {
                    $_SESSION['user_id']    = $user['id'];
                    $_SESSION['user_name']  = $user['first_name'] . ' ' . $user['last_name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['is_admin']   = true;
                    $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
                    header('Location: index.php');
                    exit;
                }
            } else {
                $error = 'Invalid email or password.';
            }
        } catch (Exception $e) {
            $error = 'Database error. Please check config/database.php settings.';
        }
    } else {
        $error = 'Please enter email and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login – Finvestmart</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body { background: linear-gradient(135deg, #0A2540 0%, #1a3a5c 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
    .admin-login-box { background: #fff; border-radius: 20px; padding: 40px; width: 100%; max-width: 420px; box-shadow: 0 24px 64px rgba(0,0,0,0.3); }
    .admin-login-logo { display: flex; align-items: center; gap: 10px; font-size: 1.4rem; font-weight: 800; color: var(--primary-color); margin-bottom: 8px; font-family: 'Poppins', sans-serif; }
    .admin-login-logo .nav-logo-icon { width: 36px; height: 36px; background: var(--primary-color); color: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; }
    .admin-badge { display: inline-block; background: rgba(239,68,68,0.1); color: #DC2626; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 6px; margin-bottom: 24px; }
    .error-box { background: #FEF2F2; border: 1px solid #FECACA; color: #DC2626; padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 16px; }
    h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 6px; }
    p { color: var(--secondary-text); font-size: 0.875rem; margin-bottom: 24px; }
  </style>
</head>
<body>
  <div class="admin-login-box">
    <div class="admin-login-logo">
      <div class="nav-logo-icon">F</div>
      Finvestmart
    </div>
    <span class="admin-badge"><i class="fas fa-shield-check"></i> Admin Access</span>
    <h2>Admin Sign In</h2>
    <p>Enter your admin credentials to access the control panel.</p>

    <?php if ($error): ?>
    <div class="error-box"><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="form-group">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-input" placeholder="admin@finvestmart.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required autofocus />
      </div>
      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" placeholder="Admin password" required />
      </div>
      <button type="submit" class="btn btn-primary btn-full" style="margin-top:8px;">
        <i class="fas fa-sign-in-alt"></i> Sign In to Admin Panel
      </button>
    </form>

    <div style="text-align:center;margin-top:20px;">
      <a href="../index.html" style="font-size:0.8rem;color:var(--secondary-text);"><i class="fas fa-arrow-left"></i> Back to Website</a>
    </div>

    <div style="margin-top:24px;padding:14px;background:var(--light-bg);border-radius:10px;font-size:0.78rem;color:var(--secondary-text);">
      <strong>Default admin login:</strong><br/>
      Email: <code>admin@finvestmart.com</code><br/>
      Password: <code>Admin@123</code><br/>
      <span style="color:#DC2626;">Change this immediately after first login!</span>
    </div>
  </div>
</body>
</html>
