<?php
/**
 * FINVESTMART - APPLICATION SUBMISSION API
 * POST: /api/applications/submit.php
 */
session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed.');
}

$product  = sanitize($_POST['product'] ?? '');
$name     = sanitize($_POST['name'] ?? '');
$phone    = sanitize($_POST['phone'] ?? '');
$email    = sanitize($_POST['email'] ?? '');

// Product-specific fields
$extra_data = [];
foreach ($_POST as $key => $val) {
    if (!in_array($key, ['product','name','phone','email'])) {
        $extra_data[$key] = sanitize($val);
    }
}

// Validation
if (!$product || !$name || !$phone) {
    jsonResponse(false, 'Name and mobile are required.');
}
if (!preg_match('/^[6-9]\d{9}$/', preg_replace('/\s/', '', $phone))) {
    jsonResponse(false, 'Enter a valid 10-digit mobile number.');
}

// Reward amounts by product
$reward_map = [
    'insurance'      => 1500,
    'personal_loan'  => 3000,
    'home_loan'      => 5000,
    'business_loan'  => 4000,
    'demat'          => 700,
    'investments'    => 1000,
    'credit_card'    => 2000,
];

$reward_amount = $reward_map[$product] ?? 500;

try {
    $db = getDB();

    // Get user_id if logged in
    $user_id = $_SESSION['user_id'] ?? null;

    // If not logged in, create a guest record or find by phone
    if (!$user_id) {
        $stmt = $db->prepare("SELECT id FROM users WHERE phone = ? LIMIT 1");
        $stmt->execute([$phone]);
        $existing = $stmt->fetch();
        if ($existing) {
            $user_id = $existing['id'];
        }
    }

    // Insert application
    $stmt = $db->prepare("
        INSERT INTO applications
        (user_id, product_type, applicant_name, phone, email, extra_data, reward_amount, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
    ");
    $stmt->execute([
        $user_id,
        $product,
        $name,
        $phone,
        $email,
        json_encode($extra_data),
        $reward_amount
    ]);
    $app_id = $db->lastInsertId();

    // Create reward record
    $stmt = $db->prepare("
        INSERT INTO rewards (user_id, application_id, product_type, amount, status, created_at)
        VALUES (?, ?, ?, ?, 'pending', NOW())
    ");
    $stmt->execute([$user_id, $app_id, $product, $reward_amount]);

    jsonResponse(true, 'Application submitted successfully! We will review and contact you within 24 hours.', [
        'application_id' => $app_id,
        'reward_amount'  => $reward_amount,
        'tracking_id'    => 'APP' . str_pad($app_id, 6, '0', STR_PAD_LEFT)
    ]);

} catch (PDOException $e) {
    jsonResponse(false, 'Submission failed. Please try again.');
}
?>
