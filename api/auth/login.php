<?php
/**
 * FINVESTMART - USER LOGIN API
 * POST: /api/auth/login.php
 */
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed.');
}

$credential = sanitize($_POST['email'] ?? '');
$password   = $_POST['password'] ?? '';
$remember   = isset($_POST['remember_me']);

if (!$credential || !$password) {
    jsonResponse(false, 'Email/mobile and password are required.');
}

try {
    $db = getDB();

    // Find user by email or phone
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? OR phone = ? LIMIT 1");
    $stmt->execute([$credential, $credential]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        jsonResponse(false, 'Invalid email/mobile or password. Please try again.');
    }

    if ($user['status'] === 'blocked') {
        jsonResponse(false, 'Your account has been suspended. Please contact support.');
    }

    // Update last login
    $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);

    // Set session
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_name']  = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['is_admin']   = (bool)($user['is_admin'] ?? false);

    // Remember me cookie (30 days)
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        $db->prepare("UPDATE users SET remember_token = ? WHERE id = ?")->execute([$token, $user['id']]);
        setcookie('remember_token', $token, time() + (30 * 24 * 3600), '/', '', true, true);
    }

    jsonResponse(true, 'Login successful!', [
        'user_id' => $user['id'],
        'name'    => $user['first_name'] . ' ' . $user['last_name'],
        'is_admin'=> (bool)($user['is_admin'] ?? false)
    ]);

} catch (PDOException $e) {
    jsonResponse(false, 'Login failed. Please try again.');
}
?>
