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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perguntas - <?= htmlspecialchars($quiz['titulo']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/editar_perguntas.css">
</head>
<body>
    <div class="main-layout">
        <!-- Área principal do conteúdo -->
        <div class="content-area">
            <div class="container">
                <div class="form-header">
                    <h1>Editar Perguntas</h1>
                    <div class="subtitle"><?= htmlspecialchars($quiz['titulo']) ?></div>
                </div>

                <div class="form-content">
                    <div class="section">
                        <h2 class="section-title">Adicionar Nova Pergunta</h2>
                        <div class="question-card">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="enunciado">Digite a pergunta</label>
                                    <textarea name="enunciado" id="enunciado" placeholder="Digite sua pergunta aqui..." required></textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="tipo">Tipo de pergunta</label>
                                    <select name="tipo" id="tipo">
                                        <option value="multipla_escolha">Múltipla Escolha</option>
                                        <option value="verdadeiro_falso">Verdadeiro ou Falso</option>
                                    </select>
                                </div>
                                
                                <button class="botao" type="submit" name="nova_pergunta">Adicionar Pergunta</button>
                            </form>
                        </div>
                    </div>

                    <div class="section">
                        <h2 class="section-title">Perguntas Existentes</h2>
                        
                        <?php if (empty($perguntas)): ?>
                            <div class="empty-state">
                                <div class="empty-state-icon">📝</div>
                                <p>Nenhuma pergunta adicionada ainda.</p>
                                <p>Comece criando sua primeira pergunta acima!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($perguntas as $p): ?>
                                <div class="pergunta" data-tipo="<?= $p['tipo'] ?>">
                                    <strong>Pergunta #<?= $p['id'] ?></strong>
                                    <div class="pergunta-content">
                                        <?= htmlspecialchars($p['enunciado']) ?>
                                    </div>
                                    <div class="pergunta-tipo">
                                        <?= $p['tipo'] === 'multipla_escolha' ? 'Múltipla Escolha' : 'Verdadeiro ou Falso' ?>
                                    </div>
                                    <div class="actions">
                                        <a href="editarRespostas.php?questao_id=<?= $p['id'] ?>">Editar Respostas</a>
                                        <a href="excluir/excluir_pergunta.php?id=<?= $p['id'] ?>&quiz_id=<?= $quiz_id ?>" 
                                            class="delete-link" 
                                            onclick="return confirm('Deseja realmente excluir esta pergunta?')">Excluir
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
        // Funcionalidade do botão mobile do chat
        function toggleMobileChat() {
            alert('Chat com IA em desenvolvimento!\n\nEm breve você poderá conversar com nossa IA para ajudar na criação de perguntas e respostas.');
        }
    </script>
</body>
</html> 