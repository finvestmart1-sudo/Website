<?php
/**
 * FINVESTMART - CLAIM REWARD API
 * POST: /api/rewards/claim.php
 */
session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, 'Method not allowed.');
}

$reward_id = (int)($_POST['reward_id'] ?? 0);
$user_id   = $_SESSION['user_id'];

if (!$reward_id) {
    jsonResponse(false, 'Invalid reward ID.');
}

try {
    $db = getDB();

    // Get reward
    $stmt = $db->prepare("SELECT * FROM rewards WHERE id = ? AND user_id = ? LIMIT 1");
    $stmt->execute([$reward_id, $user_id]);
    $reward = $stmt->fetch();

    if (!$reward) {
        jsonResponse(false, 'Reward not found.');
    }

    if ($reward['status'] === 'paid') {
        jsonResponse(false, 'This reward has already been paid.');
    }

    if ($reward['status'] !== 'eligible') {
        jsonResponse(false, 'This reward is not yet eligible for claiming. Please wait for application approval.');
    }

    // Check if bank details are added
    $stmt = $db->prepare("SELECT id FROM bank_details WHERE user_id = ? LIMIT 1");
    $stmt->execute([$user_id]);
    if (!$stmt->fetch()) {
        jsonResponse(false, 'Please add your bank/UPI details in dashboard before claiming.', ['redirect' => '/dashboard.html']);
    }

    // Update reward status to claimed
    $db->prepare("UPDATE rewards SET status = 'claimed', claimed_at = NOW() WHERE id = ?")->execute([$reward_id]);

    jsonResponse(true, 'Reward claimed! Payment will be processed within 48 hours.', [
        'amount' => $reward['amount'],
        'reward_id' => $reward_id
    ]);

} catch (PDOException $e) {
    jsonResponse(false, 'Claim failed. Please try again.');
}
?>
