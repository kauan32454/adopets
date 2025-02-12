<?php
// Incluir o arquivo de conexão
include('conexao.php');
 
// Receber os dados do formulário
$nome_usuario = $_POST['nome_usuario'];
$senha = $_POST['senha'];
 
// Verificar se o usuário existe no banco
$sql = "SELECT * FROM Usuarios WHERE nome_usuario = ? AND senha = SHA2(?, 256)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nome_usuario, $senha);
$stmt->execute();
$result = $stmt->get_result();
 
if ($result->num_rows > 0) {
    echo "Login bem-sucedido! Bem-vindo, $nome_usuario!";
} else {
    echo "Nome de usuário ou senha incorretos!";
}
 
// Fechar a conexão
$stmt->close();
$conn->close();
?>