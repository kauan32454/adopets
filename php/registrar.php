<?php
include "config.php"; // Conexão com o banco de dados

header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem
header("Content-Type: application/json; charset=UTF-8");

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos!"]);
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT); // Criptografa a senha

// Verifica se o usuário já existe
$sql = "SELECT * FROM usuarios WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Usuário já existe!"]);
} else {
    $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $passwordHash);
    
    if ($stmt->execute()) {
        // Redireciona para login.html
        header("Location: /login.html");
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Erro ao registrar usuário."]);
    }
}


if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redireciona se já estiver logado
    exit();
}
?>
?>
