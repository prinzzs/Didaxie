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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Respostas - Questão <?= $questao_id ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/editar_respostas.css">
</head>
<body>
    <div class="main-layout">
        <!-- Área principal do conteúdo -->
        <div class="content-area">
            <div class="container">
                <div class="form-header">
                    <h1>Editar Respostas</h1>
                    <div class="question-preview">
                        <div class="question-preview-title">Pergunta</div>
                        <div class="question-text"><?= htmlspecialchars($questao['enunciado']) ?></div>
                    </div>
                </div>

                <div class="form-content">
                    <div class="back-nav">
                        <a href="editarPerguntas.php?id=<?= $quiz_id ?>" class="back-link">Voltar para Perguntas</a>
                    </div>

                    <div class="section">
                        <h2 class="section-title">Adicionar Nova Resposta</h2>
                        <div class="add-response-card">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="texto">Texto da resposta</label>
                                    <input type="text" name="texto" id="texto" placeholder="Digite o texto da resposta..." required>
                                </div>
                                
                                <div class="checkbox-group">
                                    <label class="custom-checkbox">
                                        <input type="checkbox" name="correta">
                                        <div class="checkbox-design"></div>
                                    </label>
                                    <span class="checkbox-label">Esta é a resposta correta</span>
                                </div>
                                
                                <button class="botao" type="submit" name="nova_resposta">Adicionar Resposta</button>
                            </form>
                        </div>
                    </div>

                    <div class="section">
                        <h2 class="section-title">Respostas Existentes</h2>
                        
                        <?php if (empty($respostas)): ?>
                            <div class="empty-state">
                                <div class="empty-state-icon">💬</div>
                                <p>Nenhuma resposta adicionada ainda.</p>
                                <p>Comece criando as opções de resposta para esta pergunta!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($respostas as $r): ?>
                                <div class="resposta <?= $r['correta'] ? 'correct' : 'incorrect' ?>">
                                    <div class="response-id">#<?= $r['id'] ?></div>
                                    <div class="response-text"><?= htmlspecialchars($r['texto']) ?></div>
                                    <div class="response-status <?= $r['correta'] ? 'correct' : 'incorrect' ?>">
                                        <?php if ($r['correta']): ?>
                                            <span>✓</span> Correta
                                        <?php else: ?>
                                            <span>✗</span> Incorreta
                                        <?php endif; ?>
                                    </div>
                                    <div class="actions">
                                        <a href="editar/editar_resposta.php?id=<?= $r['id'] ?>&questao_id=<?= $questao_id ?>">Editar</a>
                                        <a href="excluir/excluir_resposta.php?id=<?= $r['id'] ?>&questao_id=<?= $questao_id ?>" 
                                            class="delete-link" 
                                            onclick="return confirm('Deseja realmente excluir esta resposta?')">
                                            Excluir
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Sidebar (Desktop) -->
        <div class="chat-sidebar">
            <div class="chat-header">
                <h3>🤖 Assistente IA</h3>
                <div class="chat-status">Em breve disponível</div>
            </div>
            <div class="chat-content">
                <div class="chat-placeholder-icon">💬</div>
                <div class="chat-placeholder-text">
                    <strong>Chat com IA em desenvolvimento</strong><br>
                    Em breve você poderá conversar com nossa IA para ajudar na criação de perguntas e respostas!
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Mobile Button -->
    <button class="chat-mobile-btn" onclick="toggleMobileChat()">
        💬
    </button>

    <script>
        function toggleMobileChat() {
            alert('Chat com IA em desenvolvimento!\n\nEm breve você poderá conversar com nossa IA para ajudar na criação de perguntas e respostas.');
        }
    </script>
</body>
</html>