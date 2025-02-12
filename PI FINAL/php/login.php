<?php
session_start();
include "config.php";

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? '');
    $password = trim($_POST["password"] ?? '');

    // Query ajustada para ignorar diferenças de maiúsculas/minúsculas
    $sql = "SELECT * FROM usuarios WHERE LOWER(username) = LOWER(?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro na preparação: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {
            $_SESSION["username"] = $user["username"];
            header("Location: ../index1.html");
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
} else {
    echo "Método inválido.";
}
// Verifica se os campos estão preenchidos
if (empty($username) || empty($password)) {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos!"]);
    exit();
}

// Verifica se o usuário existe no banco de dados
$sql = "SELECT * FROM usuarios WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verifica a senha
    if (password_verify($password, $user['password'])) {
        $_SESSION["username"] = $user['username']; // Salva na sessão

        echo json_encode(["success" => true, "message" => "Login bem-sucedido!"]);
        header("Location: index1.html"); // Redireciona para a página inicial
        exit();
    } else {
        echo json_encode(["success" => false, "message" => "Senha incorreta!"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado!"]);
}

// Se o usuário já estiver logado, redireciona para a página principal ou perfil
if (isset($_SESSION['username'])) {
    header("Location: index1.php"); // ou "perfil.php", conforme sua estrutura
    exit();
}
?>
