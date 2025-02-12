<?php
$host = "127.0.0.1";
$user = "root";
$password = "";
$dbname = "cadastro";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
