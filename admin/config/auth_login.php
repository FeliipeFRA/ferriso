<?php
require_once __DIR__.'/php_init.php';
require_once __DIR__.'/../../config/db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok'=>false,'error'=>'Método inválido']); exit;
}

if (!csrf_check($_POST['csrf'] ?? '')) {
  http_response_code(400);
  echo json_encode(['ok'=>false,'error'=>'Sua sessão expirou. Atualize a página e tente novamente.']); exit;
}

$login = trim($_POST['usuario'] ?? '');
$senha = (string)($_POST['password'] ?? '');

if ($login === '' || $senha === '') {
  echo json_encode(['ok'=>false,'error'=>'Preencha usuário e senha.']); exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$stmt = mysqli_prepare($con, "SELECT id,nome,login,role,ativo,senha_hash FROM usuarios WHERE login=? LIMIT 1");
mysqli_stmt_bind_param($stmt, 's', $login);
mysqli_stmt_execute($stmt);
$u = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($u && (int)$u['ativo'] === 1 && password_verify($senha, $u['senha_hash'])) {
  session_regenerate_id(true);
  $_SESSION['user'] = [
    'id'    => (int)$u['id'],
    'nome'  => $u['nome'],
    'login' => $u['login'],
    'role'  => $u['role']
  ];
  echo json_encode(['ok'=>true,'redirect'=>'/admin/home.php']); exit;
}

echo json_encode(['ok'=>false,'error'=>'Usuário ou senha inválidos.']); exit;
