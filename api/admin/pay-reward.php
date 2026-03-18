<?php
/**
 * FINVESTMART - PAY REWARD (Admin)
 * POST: /api/admin/pay-reward.php
 */
session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';
// requireAdmin(); // Uncomment in production

$reward_id = (int)($_POST['reward_id'] ?? 0);

if (!$reward_id) {
    jsonResponse(false, 'Invalid reward ID.');
}

try {
    $db = getDB();

    // Get reward with user bank details
    $stmt = $db->prepare("
        SELECT r.*, u.first_name, u.last_name, u.email, u.phone,
               b.account_number, b.ifsc_code, b.upi_id, b.account_name
        FROM rewards r
        LEFT JOIN users u ON r.user_id = u.id
        LEFT JOIN bank_details b ON r.user_id = b.user_id
        WHERE r.id = ? LIMIT 1
    ");
    $stmt->execute([$reward_id]);
    $reward = $stmt->fetch();

    if (!$reward) {
        jsonResponse(false, 'Reward not found.');
    }

    if ($reward['status'] === 'paid') {
        jsonResponse(false, 'Already paid.');
    }

    // Generate transaction ID
    $txn_id = 'TXN' . date('Y') . str_pad($reward_id, 8, '0', STR_PAD_LEFT);

    // Mark as paid
    $db->prepare("UPDATE rewards SET status = 'paid', paid_at = NOW(), transaction_id = ? WHERE id = ?")->execute([$txn_id, $reward_id]);

    // Create payout record
    $db->prepare("
        INSERT INTO payouts (user_id, reward_id, amount, transaction_id, method, status, paid_at)
        VALUES (?, ?, ?, ?, 'bank', 'completed', NOW())
    ")->execute([$reward['user_id'], $reward_id, $reward['amount'], $txn_id]);

    jsonResponse(true, 'Reward paid successfully!', ['transaction_id' => $txn_id]);

} catch (PDOException $e) {
    jsonResponse(false, 'Payment failed.');
}
?>
