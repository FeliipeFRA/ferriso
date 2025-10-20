<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$dbname = 'u374171611_bd_ferriso';
$user = 'u374171611_adminferriso';
$pass = '&[48ek0T';
$port = 3306;

// criar a conexao do banco
try {
    $con = new mysqli($host, $user, $pass, $dbname, $port);
    $con->set_charset('utf8mb4');
}  catch (mysqli_sql_exception $e) {
    error_log('MySQLi connect error: ' . $e->getMessage());
    http_response_code(500);
    exit('erro ao conectar ao banco.');
}