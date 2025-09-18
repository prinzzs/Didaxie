<?php
declare(strict_types=1);
session_start();
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = 'usbw';
$DB_NAME = 'didaxie';

// Conexão com MySQL
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    die("Erro ao conectar no MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Pegar o ID do quiz da URL
$quiz_id = $_GET['id'] ?? null;
if (!$quiz_id || !is_numeric($quiz_id)) {
    die("Quiz inválido.");
}

// Buscar quiz
$stmt = $mysqli->prepare("SELECT titulo FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$quiz = $result->fetch_assoc();
if (!$quiz) {
    die("Quiz não encontrado.");
}

// Função para criar nova pergunta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_pergunta'])) {
    $enunciado = $_POST['enunciado'] ?? '';
    $tipo = $_POST['tipo'] ?? 'multipla_escolha';

    if ($enunciado) {
        $stmt = $mysqli->prepare("INSERT INTO questoes (quiz_id, enunciado, tipo) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $quiz_id, $enunciado, $tipo);
        $stmt->execute();
        header("Location: editarPerguntas.php?id=$quiz_id");
        exit;
    }
}

// Buscar perguntas existentes
$stmt = $mysqli->prepare("SELECT * FROM questoes WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$perguntas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar Perguntas - <?= htmlspecialchars($quiz['titulo']) ?></title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f7f7f7; }
h1 { color: #333; }
.pergunta { background: #fff; padding: 15px; margin-bottom: 10px; border-radius: 6px; border: 1px solid #ddd; }
.pergunta textarea { width: 100%; height: 60px; }
.botao { padding: 8px 12px; margin-top: 5px; cursor: pointer; }
</style>
</head>
<body>
<h1>Editar Perguntas do Quiz: <?= htmlspecialchars($quiz['titulo']) ?></h1>

<h2>Adicionar Nova Pergunta</h2>
<form method="POST">
    <textarea name="enunciado" placeholder="Digite a pergunta..." required></textarea><br>
    <select name="tipo">
        <option value="multipla_escolha">Múltipla Escolha</option>
        <option value="verdadeiro_falso">Verdadeiro ou Falso</option>
    </select><br>
    <button class="botao" type="submit" name="nova_pergunta">Adicionar Pergunta</button>
</form>

<h2>Perguntas Existentes</h2>
<?php foreach ($perguntas as $p): ?>
<div class="pergunta">
    <strong>ID: <?= $p['id'] ?></strong><br>
    <?= htmlspecialchars($p['enunciado']) ?><br>
    Tipo: <?= $p['tipo'] ?><br>
    <a href="editarRespostas.php?questao_id=<?= $p['id'] ?>">Editar Respostas</a> |
    <a href="deletarPergunta.php?id=<?= $p['id'] ?>&quiz_id=<?= $quiz_id ?>" onclick="return confirm('Deseja realmente excluir esta pergunta?')">Excluir</a>
</div>
<?php endforeach; ?>

</body>
</html>
