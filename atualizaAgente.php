<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($_SESSION['usuario_id']) || !isset($data['agente'])) {
    echo json_encode(['success' => false]);
    exit;
}

$alunoId = $_SESSION['usuario_id'];
$agente = $data['agente'];

// Conexão
$conn = new mysqli('localhost', 'root', '', 'didaxie');
if($conn->connect_error){
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $conn->prepare("UPDATE alunos SET personagem=? WHERE id=?");
$stmt->bind_param("si", $agente, $alunoId);
$stmt->execute();

echo json_encode(['success' => $stmt->affected_rows > 0]);
