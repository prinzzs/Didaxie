<?php
declare(strict_types=1);
session_start();

// Configurações do banco
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'didaxie';

// Conexão MySQL
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    die("Erro ao conectar no MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Pegar parâmetros da URL
$resposta_id = $_GET['id'] ?? null;
$questao_id = $_GET['questao_id'] ?? null;

if (!$resposta_id || !is_numeric($resposta_id) || !$questao_id || !is_numeric($questao_id)) {
    die("Parâmetros inválidos.");
}

// Preparar delete seguro
$stmt = $mysqli->prepare("DELETE FROM respostas WHERE id = ?");
$stmt->bind_param("i", $resposta_id);
if ($stmt->execute()) {
    // Redireciona de volta para a edição do quiz
    header("Location: ../editarRespostas.php?questao_id=$questao_id");
    exit;
} else {
    die("Erro ao excluir a resposta: " . $mysqli->error);
}
