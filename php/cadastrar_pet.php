<?php
include "config.php"; // Inclui o arquivo de conexão com o banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? '';
    $raca = $_POST["raca"] ?? '';
    $idade      = isset($_POST["idade"]) ? intval($_POST["idade"]) : 0;
    $cidade = $_POST["cidade"] ?? '';
    $telefone = $_POST["telefone"] ?? '';
    $descricao = $_POST["descricao"] ?? '';
    $imagem = "";

 // Processa o upload da imagem
 if (!empty($_FILES["imagem"]["name"])) {
    $diretorio = "uploads/";
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }
    $imagem = $diretorio . basename($_FILES["imagem"]["name"]);
    if(!move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
        echo "<script>alert('Erro no upload da imagem!'); window.history.back();</script>";
        exit();
    }
}
    // Insere os dados no banco
    $sql = "INSERT INTO pets (nome, raca, idade, cidade, telefone, descricao, imagem) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissss", $nome, $raca, $idade, $cidade, $telefone, $descricao, $imagem);

    if ($stmt->execute()) {
        echo "<script>alert('Pet cadastrado com sucesso!'); window.location.href = '../index.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar!'); window.history.back();</script>";
    }



    $idade = isset($_POST["idade"]) ? intval($_POST["idade"]) : 0;

    $imagem = "";
if (!empty($_FILES["imagem"]["name"])) {
    $diretorio = "uploads/"; // Pasta onde as imagens serão salvas
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }
    $imagem = $diretorio . basename($_FILES["imagem"]["name"]);
    if(!move_uploaded_file($_FILES["imagem"]["tmp_name"], $imagem)) {
        // Se houver erro no upload, você pode tratar aqui
        echo "<script>alert('Erro no upload da imagem'); window.history.back();</script>";
        exit();
    }
}

    $stmt->close();
    $conn->close();
}
?>