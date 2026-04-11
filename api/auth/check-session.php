<?php
/**
 * FINVESTMART - CHECK SESSION STATUS
 * GET: /api/auth/check-session.php
 * Returns JSON: { loggedIn: bool, name, email, totalRewards, pendingRewards, paidOut, applications }
 */
session_start();
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['loggedIn' => false]);
    exit;
}

require_once '../../config/database.php';

try {
    $db = getDB();

    $stmt = $db->prepare("
        SELECT u.first_name, u.last_name, u.email,
               COALESCE(SUM(CASE WHEN r.status = 'paid' THEN r.amount ELSE 0 END), 0)               AS total_rewards,
               COALESCE(SUM(CASE WHEN r.status IN ('eligible','claimed') THEN r.amount ELSE 0 END), 0) AS pending_rewards,
               COALESCE(SUM(CASE WHEN r.status = 'paid' THEN r.amount ELSE 0 END), 0)               AS paid_out,
               COUNT(DISTINCT a.id)                                                                  AS total_apps
        FROM users u
        LEFT JOIN rewards      r ON r.user_id = u.id
        LEFT JOIN applications a ON a.user_id = u.id
        WHERE u.id = ?
        GROUP BY u.id
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $row = $stmt->fetch();

    echo json_encode([
        'loggedIn'       => true,
        'user_id'        => (int)$_SESSION['user_id'],
        'name'           => trim(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?: $_SESSION['user_name'],
        'email'          => $row['email'] ?? $_SESSION['user_email'],
        'totalRewards'   => (float)($row['total_rewards']   ?? 0),
        'pendingRewards' => (float)($row['pending_rewards'] ?? 0),
        'paidOut'        => (float)($row['paid_out']        ?? 0),
        'applications'   => (int)  ($row['total_apps']      ?? 0),
    ]);

} catch (Exception $e) {
    // DB unavailable — still confirm session is valid
    echo json_encode([
        'loggedIn'       => true,
        'user_id'        => (int)$_SESSION['user_id'],
        'name'           => $_SESSION['user_name']  ?? 'User',
        'email'          => $_SESSION['user_email'] ?? '',
        'totalRewards'   => 0,
        'pendingRewards' => 0,
        'paidOut'        => 0,
        'applications'   => 0,
    ]);
}
exit;
?>
