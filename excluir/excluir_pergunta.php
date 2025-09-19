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
$pergunta_id = $_GET['id'] ?? null;
$quiz_id = $_GET['quiz_id'] ?? null;

if (!$pergunta_id || !is_numeric($pergunta_id) || !$quiz_id || !is_numeric($quiz_id)) {
    die("Parâmetros inválidos.");
}

// Preparar delete seguro
$stmt = $mysqli->prepare("DELETE FROM questoes WHERE id = ?");
$stmt->bind_param("i", $pergunta_id);
if ($stmt->execute()) {
    // Redireciona de volta para a edição do quiz
    header("Location: ../editarPerguntas.php?id=$quiz_id");
    exit;
} else {
    die("Erro ao excluir a pergunta: " . $mysqli->error);
}
