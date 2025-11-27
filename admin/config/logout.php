<?php
require_once __DIR__.'/php_init.php';

$_SESSION = [];
if (ini_get('session.use_cookies')) {
  $p = session_get_cookie_params();
  setcookie(
    session_name(),
    '',
    time() - 42000,
    $p['path'],
    $p['domain'] ?? '',
    $p['secure'],
    $p['httponly']
  );
}

session_destroy();

// redireciona para /admin/login.php
redirect('../login.php');        // relativo a /admin/config/logout.php
// (se preferir absoluto na raiz: redirect('/admin/login.php');)
