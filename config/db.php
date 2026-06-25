<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$dbname = 'fel87493_bd_ferriso';
$user = 'fel87493_ferriso';
$pass = 'UiGLysZA)Tc(';
$port = 3306;

try {
    $con = new mysqli($host, $user, $pass, $dbname, $port);
    $con->set_charset('utf8mb4');
    mysqli_query($con, "SET time_zone = '-03:00'");
} catch (mysqli_sql_exception $e) {
    error_log('Erro de conexao com o banco: ' . $e->getMessage());
    http_response_code(500);
    exit('Erro interno. Tente novamente mais tarde.');
}