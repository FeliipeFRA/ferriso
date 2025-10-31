<?php
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params(['lifetime'=>0,'path'=>'/','secure'=>$secure,'httponly'=>true,'samesite'=>'Strict']);
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function csrf_token(): string {
  if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
  return $_SESSION['csrf'];
}
function csrf_check(string $t): bool {
  return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $t);
}
function redirect(string $u){ header('Location: '.$u); exit; }
