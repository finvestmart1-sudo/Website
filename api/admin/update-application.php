<?php
/**
 * FINVESTMART - UPDATE APPLICATION STATUS (Admin)
 * POST: /api/admin/update-application.php
 */
session_start();
header('Content-Type: application/json');

require_once '../../config/database.php';
// requireAdmin(); // Uncomment in production

$app_id = sanitize($_POST['app_id'] ?? '');
$status = sanitize($_POST['status'] ?? '');

if (!in_array($status, ['approved', 'rejected', 'processing'])) {
    jsonResponse(false, 'Invalid status.');
}

try {
    $db = getDB();

    // Remove # prefix if present
    $app_id_clean = ltrim($app_id, '#');

    $stmt = $db->prepare("UPDATE applications SET status = ?, updated_at = NOW() WHERE id = ?");
    $stmt->execute([$status, $app_id_clean]);

    // If approved, mark reward as eligible
    if ($status === 'approved') {
        $stmt = $db->prepare("UPDATE rewards SET status = 'eligible' WHERE application_id = ?");
        $stmt->execute([$app_id_clean]);
    }

    jsonResponse(true, "Application $status successfully.");

} catch (PDOException $e) {
    jsonResponse(false, 'Update failed.');
}
?>
