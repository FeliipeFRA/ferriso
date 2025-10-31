<?php
require_once __DIR__.'/php_init.php';
require_once __DIR__.'/../../config/db.php';

if ($_SERVER['REQUEST_METHOD']!=='POST') { http_response_code(405); exit; }
if (!csrf_check($_POST['csrf'] ?? '')) { http_response_code(400); exit('CSRF inválido'); }

$login = trim($_POST['usuario'] ?? '');
$senha = (string)($_POST['password'] ?? '');
if ($login==='' || $senha==='') redirect('/admin/login.php?err=campos');

$stmt = mysqli_prepare($con,"SELECT id,nome,login,role,ativo,senha_hash FROM usuarios WHERE login=? LIMIT 1");
mysqli_stmt_bind_param($stmt,'s',$login);
mysqli_stmt_execute($stmt);
$u = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($u && (int)$u['ativo']===1 && password_verify($senha, $u['senha_hash'])) {
  session_regenerate_id(true);
  $_SESSION['user']=['id'=>(int)$u['id'],'nome'=>$u['nome'],'login'=>$u['login'],'role'=>$u['role']];
  redirect('/admin/layout.php');
}
redirect('/admin/login.php?err=credenciais');
