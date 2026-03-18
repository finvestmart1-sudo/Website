<?php
/**
 * FINVESTMART - USER REGISTRATION API
 * POST: /api/auth/register.php
 */
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed.');
}

// Get and validate inputs
$first_name     = sanitize($_POST['first_name'] ?? '');
$last_name      = sanitize($_POST['last_name'] ?? '');
$email          = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone          = sanitize($_POST['phone'] ?? '');
$city           = sanitize($_POST['city'] ?? '');
$password       = $_POST['password'] ?? '';
$agree_terms    = isset($_POST['agree_terms']) ? 1 : 0;

// Validation
if (!$first_name || !$last_name) {
    jsonResponse(false, 'First and last name are required.');
}
if (!$email) {
    jsonResponse(false, 'Please enter a valid email address.');
}
if (!preg_match('/^[6-9]\d{9}$/', $phone)) {
    jsonResponse(false, 'Please enter a valid 10-digit mobile number.');
}
if (strlen($password) < 8) {
    jsonResponse(false, 'Password must be at least 8 characters long.');
}
if (!$agree_terms) {
    jsonResponse(false, 'You must agree to the Terms of Service.');
}

try {
    $db = getDB();

    // Check if email already exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
    $stmt->execute([$email, $phone]);
    if ($stmt->fetch()) {
        jsonResponse(false, 'An account with this email or mobile already exists. Please login.');
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    // Generate referral code
    $referral_code = strtoupper(substr($first_name, 0, 3) . rand(1000, 9999));

    // Insert user
    $stmt = $db->prepare("
        INSERT INTO users (first_name, last_name, email, phone, city, password_hash, referral_code, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->execute([$first_name, $last_name, $email, $phone, $city, $password_hash, $referral_code]);
    $user_id = $db->lastInsertId();

    // Set session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $first_name . ' ' . $last_name;
    $_SESSION['user_email'] = $email;

    jsonResponse(true, 'Account created successfully! Welcome to Finvestmart.', [
        'user_id' => $user_id,
        'name' => $first_name . ' ' . $last_name,
        'referral_code' => $referral_code
    ]);

} catch (PDOException $e) {
    jsonResponse(false, 'Registration failed. Please try again.');
}
?>
