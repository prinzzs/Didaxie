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

// Pegar o ID da questão da URL
$questao_id = $_GET['questao_id'] ?? null;
if (!$questao_id || !is_numeric($questao_id)) {
    die("Questão inválida.");
}

// Buscar questão
$stmt = $mysqli->prepare("SELECT enunciado, quiz_id FROM questoes WHERE id = ?");
$stmt->bind_param("i", $questao_id);
$stmt->execute();
$result = $stmt->get_result();
$questao = $result->fetch_assoc();
if (!$questao) {
    die("Questão não encontrada.");
}
$quiz_id = $questao['quiz_id'];

// Adicionar nova resposta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_resposta'])) {
    $texto = $_POST['texto'] ?? '';
    $correta = isset($_POST['correta']) ? 1 : 0;

    if ($texto) {
        $stmt = $mysqli->prepare("INSERT INTO respostas (questao_id, texto, correta) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $questao_id, $texto, $correta);
        $stmt->execute();
        header("Location: editarRespostas.php?questao_id=$questao_id");
        exit;
    }
}

// Buscar respostas existentes
$stmt = $mysqli->prepare("SELECT * FROM respostas WHERE questao_id = ?");
$stmt->bind_param("i", $questao_id);
$stmt->execute();
$respostas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Editar Respostas - Questão <?= $questao_id ?></title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; background: #f7f7f7; }
h1, h2 { color: #333; }
.resposta { background: #fff; padding: 10px; margin-bottom: 10px; border-radius: 6px; border: 1px solid #ddd; }
.resposta span { display: inline-block; margin-right: 10px; }
.botao { padding: 6px 10px; margin-top: 5px; cursor: pointer; }
</style>
</head>
<body>

<h1>Editar Respostas da Questão</h1>
<p><strong>Pergunta:</strong> <?= htmlspecialchars($questao['enunciado']) ?></p>
<a href="editarPerguntas.php?id=<?= $quiz_id ?>">← Voltar para Perguntas</a>

<h2>Adicionar Nova Resposta</h2>
<form method="POST">
    <input type="text" name="texto" placeholder="Texto da resposta" required>
    <label>
        <input type="checkbox" name="correta"> Correta
    </label>
    <button class="botao" type="submit" name="nova_resposta">Adicionar</button>
</form>

<h2>Respostas Existentes</h2>
<?php foreach ($respostas as $r): ?>
<div class="resposta">
    <span>ID: <?= $r['id'] ?></span>
    <span><?= htmlspecialchars($r['texto']) ?></span>
    <span><?= $r['correta'] ? '✅ Correta' : '❌ Errada' ?></span>
    <a href="editarRespostaUnica.php?id=<?= $r['id'] ?>&questao_id=<?= $questao_id ?>">Editar</a> |
    <a href="deletarResposta.php?id=<?= $r['id'] ?>&questao_id=<?= $questao_id ?>" onclick="return confirm('Deseja realmente excluir esta resposta?')">Excluir</a>
</div>
<?php endforeach; ?>

</body>
</html>
