<?php
/**
 * FINVESTMART - FORGOT PASSWORD
 * POST: /api/auth/forgot-password.php
 */
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed.');
}

$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
if (!$email) {
    jsonResponse(false, 'Please enter a valid email address.');
}

try {
    $db = getDB();

    $stmt = $db->prepare("SELECT id, first_name FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a reset token valid for 1 hour
        $token     = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600);

        $db->prepare("UPDATE users SET remember_token = ?, updated_at = NOW() WHERE id = ?")
           ->execute([$token, $user['id']]);

        $resetLink = SITE_URL . '/reset-password.html?token=' . $token;
        $name      = htmlspecialchars($user['first_name']);
        $subject   = 'Reset your Finvestmart password';
        $body      = "Hi {$name},\n\nClick the link below to reset your password (valid for 1 hour):\n\n{$resetLink}\n\nIf you did not request a password reset, you can ignore this email.\n\nRegards,\nFinvestmart Team";

        $headers  = "From: " . SITE_EMAIL . "\r\n";
        $headers .= "Reply-To: " . SITE_EMAIL . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        mail($email, $subject, $body, $headers);
    }

    // Always return success to prevent email enumeration
    jsonResponse(true, 'If this email is registered, a password reset link has been sent. Check your inbox (and spam folder).');

} catch (PDOException $e) {
    jsonResponse(false, 'Something went wrong. Please try again.');
}
?>
