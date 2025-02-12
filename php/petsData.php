<?php
include "config.php";  // Conexão com o banco de dados

header("Content-Type: application/json; charset=UTF-8");

$sql = "SELECT * FROM pets ORDER BY id DESC";
$result = $conn->query($sql);

$pets = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pets[] = $row;
    }
}

echo json_encode($pets);
?>
