<?php
require_once __DIR__.'/php_init.php';
require_once __DIR__.'/../../config/db.php';

if ($_SERVER['REQUEST_METHOD']!=='POST') { http_response_code(405); exit; }
if (!csrf_check($_POST['csrf'] ?? '')) { http_response_code(400); exit('CSRF inválido'); }

$nome = trim($_POST['nome'] ?? '');
$login = trim($_POST['login'] ?? '');
$senha = (string)($_POST['senha'] ?? '');
$conf = (string)($_POST['confirma'] ?? '');

if ($nome===''||$login===''||$senha===''||$conf==='') redirect('/admin/register.php?err=campos');
if ($senha !== $conf) redirect('/admin/register.php?err=confirmacao');

$stmt = mysqli_prepare($con,"SELECT 1 FROM usuarios WHERE login=? LIMIT 1");
mysqli_stmt_bind_param($stmt,'s',$login);
mysqli_stmt_execute($stmt);
if (mysqli_fetch_row(mysqli_stmt_get_result($stmt))) redirect('/admin/register.php?err=login_em_uso');

$existe = (int)mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(*) n FROM usuarios"))['n'];
$role = ($existe===0) ? 'admin' : 'editor';

$hash = password_hash($senha, PASSWORD_BCRYPT, ['cost'=>12]);

$stmt = mysqli_prepare($con,"INSERT INTO usuarios (nome,login,senha_hash,role,ativo) VALUES (?,?,?,?,1)");
mysqli_stmt_bind_param($stmt,'ssss',$nome,$login,$hash,$role);
mysqli_stmt_execute($stmt);

session_regenerate_id(true);
$_SESSION['user']=['id'=>mysqli_insert_id($con),'nome'=>$nome,'login'=>$login,'role'=>$role];
redirect('/admin/layout.php');
