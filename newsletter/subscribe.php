<?php
header('Content-Type: text/html; charset=utf-8');
require_once __DIR__ . '/../config/db.php';  // $con = mysqli
mysqli_set_charset($con, 'utf8mb4');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); exit('Método não permitido.');
}

$email = trim($_POST['email'] ?? '');
$agree = isset($_POST['agree']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(422); exit('E-mail inválido.');
}
if (!$agree) {
  http_response_code(422); exit('É necessário concordar para prosseguir.');
}

// Checa se já existe
$stmt = $con->prepare('SELECT id, confirmed_at, unsubscribed_at FROM newsletter_subscribers WHERE email=?');
$stmt->bind_param('s', $email);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

$token = bin2hex(random_bytes(32));

if ($row) {
  if (!empty($row['confirmed_at']) && empty($row['unsubscribed_at'])) {
    exit('Este e-mail já está inscrito.');
  }
  // Reenvia confirmação (ou reinscreve)
  $upd = $con->prepare('UPDATE newsletter_subscribers SET token=?, confirmed_at=NULL, unsubscribed_at=NULL, created_at=NOW() WHERE id=?');
  $upd->bind_param('si', $token, $row['id']);
  $upd->execute();
} else {
  $ins = $con->prepare('INSERT INTO newsletter_subscribers (email, token) VALUES (?, ?)');
  $ins->bind_param('ss', $email, $token);
  $ins->execute();
}

// Envia confirmação
$confirmLink = 'https://www.ferrisoisolamentos.com.br/newsletter/confirm.php?e='.urlencode($email).'&t='.$token;
$subject = 'Confirme sua inscrição - Ferriso Isolamentos';
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html; charset=UTF-8\r\n";
$headers .= "From: Ferriso Isolamentos <no-reply@ferrisoisolamentos.com.br>\r\n";

$body = '<p>Para confirmar sua inscrição, clique no link abaixo:</p>'
      . '<p><a href="'.$confirmLink.'">'.$confirmLink.'</a></p>'
      . '<p>Se não foi você, ignore este e-mail.</p>';

@mail($email, $subject, $body, $headers);

echo 'Pronto! Enviamos um e-mail para confirmar sua inscrição.';
