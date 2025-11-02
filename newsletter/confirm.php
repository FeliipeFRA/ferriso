<?php
require_once __DIR__ . '/../config/db.php';
mysqli_set_charset($con, 'utf8mb4');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$email = $_GET['e'] ?? '';
$token = $_GET['t'] ?? '';

$ok = false;
if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[a-f0-9]{64}$/', $token)) {
  $upd = $con->prepare("UPDATE newsletter_subscribers
                        SET confirmed_at = NOW(), token = NULL
                        WHERE email = ? AND token = ? AND unsubscribed_at IS NULL");
  $upd->bind_param('ss', $email, $token);
  $upd->execute();
  $ok = $upd->affected_rows > 0;
}

header('Location: /?nl=' . ($ok ? 'confirmed' : 'invalid'), true, 302);
exit;
