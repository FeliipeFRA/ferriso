<?php
require_once __DIR__.'/php_init.php';
function guard_user(){ return $_SESSION['user'] ?? null; }
function guard_require(){ if(!guard_user()) redirect('../login.php'); }
