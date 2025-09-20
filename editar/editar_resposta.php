<?php
declare(strict_types=1);
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'didaxie';

// Conexão com MySQL
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    die("Erro ao conectar no MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Pegar o ID da resposta da URL
$resposta_id = $_GET['id'] ?? null;
if (!$resposta_id || !is_numeric($resposta_id)) {
    die("Resposta inválida.");
}

// Buscar a resposta
$stmt = $mysqli->prepare("SELECT * FROM respostas WHERE id = ?");
$stmt->bind_param("i", $resposta_id);
$stmt->execute();
$resposta = $stmt->get_result()->fetch_assoc();
if (!$resposta) {
    die("Resposta não encontrada.");
}

$questao_id = $resposta['questao_id'];

// Buscar a questão para exibir
$stmt = $mysqli->prepare("SELECT enunciado, quiz_id FROM questoes WHERE id = ?");
$stmt->bind_param("i", $questao_id);
$stmt->execute();
$questao = $stmt->get_result()->fetch_assoc();
if (!$questao) {
    die("Questão não encontrada.");
}
$quiz_id = $questao['quiz_id'];

// Atualizar resposta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_texto = $_POST['texto'] ?? '';
    $correta = isset($_POST['correta']) ? 1 : 0;

    if ($novo_texto) {
        $stmt = $mysqli->prepare("UPDATE respostas SET texto = ?, correta = ? WHERE id = ?");
        $stmt->bind_param("sii", $novo_texto, $correta, $resposta_id);
        $stmt->execute();
        header("Location: ../editarRespostas.php?questao_id=$questao_id");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Resposta #<?= $resposta['id'] ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./editar_respostas.css">
</head>
<body>
    <div class="main-layout">
        <div class="content-area">
            <div class="container">
                <div class="form-header">
                    <h1>Editar Resposta</h1>
                    <div class="question-preview">
                        <div class="question-preview-title">Pergunta</div>
                        <div class="question-text"><?= htmlspecialchars($questao['enunciado']) ?></div>
                    </div>
                </div>

                <div class="form-content">
                    <div class="back-nav">
                        <a href="editarRespostas.php?questao_id=<?= $questao_id ?>" class="back-link">Voltar para Respostas</a>
                    </div>

                    <div class="section">
                        <h2 class="section-title">Editar Resposta #<?= $resposta['id'] ?></h2>
                        <div class="add-response-card">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="texto">Texto da resposta</label>
                                    <input type="text" name="texto" id="texto" value="<?= htmlspecialchars($resposta['texto']) ?>" required>
                                </div>
                                
                                <div class="checkbox-group">
                                    <label class="custom-checkbox">
                                        <input type="checkbox" name="correta" <?= $resposta['correta'] ? 'checked' : '' ?>>
                                        <div class="checkbox-design"></div>
                                    </label>
                                    <span class="checkbox-label">Esta é a resposta correta</span>
                                </div>
                                
                                <button class="botao" type="submit">Salvar Alterações</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="chat-sidebar">
            <div class="chat-header">
                <h3>🤖 Assistente IA</h3>
                <div class="chat-status">Em breve disponível</div>
            </div>
            <div class="chat-content">
                <div class="chat-placeholder-icon">💬</div>
                <div class="chat-placeholder-text">
                    <strong>Chat com IA em desenvolvimento</strong><br>
                    Em breve você poderá conversar com nossa IA!
                </div>
            </div>
        </div>
    </div>
</body>
</html>
