<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '../config/db.php';
require_once __DIR__ . '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contato.php');
    exit;
}

$errors = [];

// CSRF
if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    $errors[] = 'Falha na validação do formulário. Atualize a página e tente novamente.';
}

// honeypot
if (!empty($_POST['website'] ?? '')) {
    $errors[] = 'Falha na validação do formulário.';
}

// dados básicos
$nome     = trim($_POST['nome']     ?? '');
$email    = trim($_POST['email']    ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$assunto  = trim($_POST['assunto']  ?? '');
$mensagem = trim($_POST['mensagem'] ?? '');
$origem   = trim($_POST['origem']   ?? 'Site - Página de Contato');
$captcha  = trim($_POST['captcha']  ?? '');

// limita tamanho para caber na tabela
$nome     = mb_substr($nome,     0, 120);
$email    = mb_substr($email,    0, 150);
$telefone = mb_substr($telefone, 0, 50);
$assunto  = mb_substr($assunto,  0, 150);
$origem   = mb_substr($origem,   0, 60);

// validações
if ($nome === '' || mb_strlen($nome) < 3) {
    $errors[] = 'Informe um nome válido (mínimo 3 caracteres).';
}

if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Informe um e-mail válido.';
}

if ($mensagem === '' || mb_strlen($mensagem) < 10) {
    $errors[] = 'Informe uma mensagem com pelo menos 10 caracteres.';
}

if ($telefone !== '' && !preg_match('/^\(?\d{2}\)?\s?\d{4,5}-?\d{4}$/', $telefone)) {
    $errors[] = 'Informe um telefone válido no formato (16) 99999-9999.';
}

// captcha
if (!isset($_SESSION['captcha']) || (int)$captcha !== (int)$_SESSION['captcha']) {
    $errors[] = 'Resposta do captcha incorreta.';
}
unset($_SESSION['captcha']);

// se deu erro, volta para o formulário
if (!empty($errors)) {
    $_SESSION['contact_errors'] = $errors;
    $_SESSION['contact_old'] = [
        'nome'     => $nome,
        'email'    => $email,
        'telefone' => $telefone,
        'assunto'  => $assunto,
        'mensagem' => $mensagem,
    ];
    header('Location: /contato.php');
    exit;
}

// pronto para gravar
$ip         = $_SERVER['REMOTE_ADDR'] ?? '';
$lido       = 0;
$respondido = 0;

$stmt = $con->prepare("
    INSERT INTO contatos
        (nome, email, telefone, assunto, mensagem, origem, ip, lido, respondido)
    VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    $_SESSION['contact_errors'] = ['Erro interno ao preparar o cadastro da mensagem.'];
    header('Location: /contato.php');
    exit;
}

$stmt->bind_param(
    'sssssssii',
    $nome,
    $email,
    $telefone,
    $assunto,
    $mensagem,
    $origem,
    $ip,
    $lido,
    $respondido
);

if (!$stmt->execute()) {
    $_SESSION['contact_errors'] = ['Erro ao salvar sua mensagem. Tente novamente em alguns instantes.'];
    header('Location: /contato.php');
    exit;
}

$stmt->close();

$_SESSION['contact_success'] = 'Sua mensagem foi enviada com sucesso. Em breve entraremos em contato.';
header('Location: /contato.php');
exit;
