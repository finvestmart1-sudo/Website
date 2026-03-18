<?php
/**
 * FINVESTMART - DATABASE CONFIGURATION
 * =====================================
 * IMPORTANT: Change these values in Hostinger:
 * 1. Go to Hostinger hPanel > Databases > MySQL Databases
 * 2. Create a new database
 * 3. Update the values below
 */

define('DB_HOST', 'localhost');          // Usually localhost on Hostinger
define('DB_USER', 'your_db_username');   // Replace with your DB username
define('DB_PASS', 'your_db_password');   // Replace with your DB password
define('DB_NAME', 'finvestmart_db');     // Replace with your DB name

// Site Config
define('SITE_URL', 'https://yourdomain.com');     // Replace with your domain
define('SITE_NAME', 'Finvestmart');
define('SITE_EMAIL', 'support@finvestmart.com');
define('ADMIN_EMAIL', 'admin@finvestmart.com');

// Security Keys (change these!)
define('JWT_SECRET', 'change_this_to_random_long_string_abc123xyz');
define('ENCRYPTION_KEY', 'change_this_to_another_random_string_xyz789');

// Create PDO connection
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
        }
    }
    return $pdo;
}

// Utility: Send JSON response
function jsonResponse($success, $message = '', $data = []) {
    header('Content-Type: application/json');
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $data));
    exit;
}

// Utility: Sanitize input
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Utility: Check if logged in
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        jsonResponse(false, 'Please login to continue.', ['redirect' => '/login.html']);
    }
}

// Utility: Check if admin
function requireAdmin() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: ' . SITE_URL . '/login.html');
        exit;
    }
}
?>
