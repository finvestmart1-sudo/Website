<?php
session_start();
$was_admin = !empty($_SESSION['is_admin']);
session_destroy();
setcookie('remember_token', '', time() - 3600, '/');
if ($was_admin) {
    header('Location: ../../admin/login.php');
} else {
    header('Location: ../../login.html');
}
exit;
?>
