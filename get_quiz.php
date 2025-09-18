<?php
// get_quiz.php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'usbw';
$DB_NAME = 'didaxie';

$codigo = $_GET['codigo'] ?? '';
if (!$codigo) {
    echo json_encode(['error' => 'Código não fornecido']);
    exit;
}

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    echo json_encode(['error' => 'Erro ao conectar ao banco']);
    exit;
}
$mysqli->set_charset("utf8mb4");

$stmt = $mysqli->prepare("SELECT id, titulo, categoria, total_questoes FROM quizzes WHERE codigo = ? AND status = 'publicado'");
$stmt->bind_param("s", $codigo);
$stmt->execute();
$result = $stmt->get_result();

if ($quiz = $result->fetch_assoc()) {
    echo json_encode(['quiz' => $quiz]);
} else {
    echo json_encode(['error' => 'Quiz não encontrado ou não publicado']);
}
?>
