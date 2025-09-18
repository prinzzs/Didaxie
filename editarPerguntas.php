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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perguntas - <?= htmlspecialchars($quiz['titulo']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', 'Arial', sans-serif;
            background-color: #f1f3f4;
            color: #202124;
            line-height: 1.6;
        }

        /* Layout principal - Desktop */
        .main-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Área principal do conteúdo */
        .content-area {
            flex: 1;
            max-width: calc(100vw - 380px); /* Deixa espaço para o chat */
            padding: 20px;
            overflow-y: auto;
        }

        /* Container do formulário */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,.3), 0 2px 6px 2px rgba(60,64,67,.15);
            overflow: hidden;
        }

        /* Cabeçalho do formulário */
        .form-header {
            background: linear-gradient(135deg, #673ab7 0%, #512da8 100%);
            padding: 32px;
            color: white;
            position: relative;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="20" cy="80" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .form-header h1 {
            font-size: 36px;
            font-weight: 400;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .form-header .subtitle {
            font-size: 18px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Conteúdo do formulário */
        .form-content {
            padding: 32px;
        }

        /* Seções */
        .section {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 500;
            color: #202124;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 3px solid #e8eaed;
        }

        /* Card de pergunta */
        .question-card {
            background: white;
            border: 1px solid #e8eaed;
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,.08);
            transition: box-shadow 0.3s ease;
        }

        .question-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,.12);
        }

        /* Formulário de nova pergunta */
        .form-group {
            margin-bottom: 28px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            font-weight: 500;
            color: #5f6368;
            margin-bottom: 12px;
        }

        .form-group textarea {
            width: 100%;
            min-height: 140px;
            padding: 20px;
            border: 2px solid #dadce0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 16px;
            resize: vertical;
            transition: border-color 0.2s ease;
            background-color: #fafafa;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #673ab7;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(103,58,183,.1);
        }

        .form-group select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #dadce0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 16px;
            background-color: #fafafa;
            color: #3c4043;
            cursor: pointer;
            transition: border-color 0.2s ease;
        }

        .form-group select:focus {
            outline: none;
            border-color: #673ab7;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(103,58,183,.1);
        }

        /* Botões */
        .botao {
            background-color: #673ab7;
            color: white;
            border: none;
            padding: 16px 32px;
            border-radius: 28px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .botao:hover {
            background-color: #5e35b1;
            box-shadow: 0 4px 16px rgba(103,58,183,.3);
            transform: translateY(-2px);
        }

        .botao:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(103,58,183,.3);
        }

        /* Card de pergunta existente */
        .pergunta {
            background: white;
            border: 1px solid #e8eaed;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            position: relative;
            transition: all 0.3s ease;
        }

        .pergunta:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            border-color: #dadce0;
            transform: translateY(-2px);
        }

        .pergunta strong {
            color: #5f6368;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .pergunta-content {
            margin: 16px 0;
            font-size: 18px;
            line-height: 1.6;
        }

        .pergunta-tipo {
            color: #673ab7;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 20px;
            background: rgba(103,58,183,.12);
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-block;
        }

        /* Links de ação */
        .actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .actions a {
            color: #673ab7;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            padding: 12px 20px;
            border-radius: 24px;
            transition: all 0.2s ease;
            border: 1px solid rgba(103,58,183,.2);
        }

        .actions a:hover {
            background-color: rgba(103,58,183,.1);
            border-color: rgba(103,58,183,.3);
        }

        .actions a.delete-link {
            color: #d93025;
            border-color: rgba(217,48,37,.2);
        }

        .actions a.delete-link:hover {
            background-color: rgba(217,48,37,.1);
            border-color: rgba(217,48,37,.3);
        }

        /* Estado vazio */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #5f6368;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.6;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 8px;
        }

        /* === CHAT SIDEBAR DESKTOP === */
        .chat-sidebar {
            width: 380px;
            background: #fff;
            border-left: 1px solid #e8eaed;
            display: flex;
            flex-direction: column;
            position: fixed;
            right: 0;
            top: 0;
            bottom: 0;
            box-shadow: -2px 0 8px rgba(0,0,0,.1);
        }

        .chat-header {
            padding: 20px;
            background: linear-gradient(135deg, #4285f4 0%, #1a73e8 100%);
            color: white;
            border-bottom: 1px solid rgba(255,255,255,.2);
        }

        .chat-header h3 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .chat-status {
            font-size: 14px;
            opacity: 0.8;
        }

        .chat-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #5f6368;
        }

        .chat-placeholder-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .chat-placeholder-text {
            font-size: 16px;
            line-height: 1.5;
        }

        /* === CHAT MOBILE FLOATING BUTTON === */
        .chat-mobile-btn {
            display: none;
            position: fixed;
            right: 20px;
            bottom: 20px;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4285f4 0%, #1a73e8 100%);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(66,133,244,.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            z-index: 1000;
        }

        .chat-mobile-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(66,133,244,.5);
        }

        .chat-mobile-btn:active {
            transform: scale(0.95);
        }

        /* === RESPONSIVIDADE === */
        @media (max-width: 1200px) {
            .content-area {
                max-width: calc(100vw - 320px);
            }
            
            .chat-sidebar {
                width: 320px;
            }
            
            .form-content {
                padding: 24px;
            }
            
            .question-card,
            .pergunta {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .main-layout {
                flex-direction: column;
            }
            
            .content-area {
                max-width: 100%;
                padding: 12px;
            }
            
            .chat-sidebar {
                display: none;
            }
            
            .chat-mobile-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .form-header {
                padding: 24px;
            }
            
            .form-header h1 {
                font-size: 28px;
            }
            
            .form-header .subtitle {
                font-size: 16px;
            }
            
            .form-content {
                padding: 20px;
            }
            
            .section-title {
                font-size: 20px;
            }
            
            .question-card,
            .pergunta {
                padding: 20px;
            }
            
            .actions {
                flex-direction: column;
                gap: 12px;
                align-items: stretch;
            }
            
            .actions a {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .content-area {
                padding: 8px;
            }
            
            .form-header {
                padding: 20px;
            }
            
            .form-header h1 {
                font-size: 24px;
            }
            
            .form-content {
                padding: 16px;
            }
            
            .question-card,
            .pergunta {
                padding: 16px;
            }
            
            .chat-mobile-btn {
                width: 56px;
                height: 56px;
                right: 16px;
                bottom: 16px;
                font-size: 20px;
            }
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pergunta,
        .question-card {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .chat-sidebar {
            animation: slideInRight 0.3s ease-out;
        }

        /* Scrollbar personalizada para desktop */
        .content-area::-webkit-scrollbar {
            width: 8px;
        }

        .content-area::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .content-area::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        .content-area::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
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
                                        <a href="deletarPergunta.php?id=<?= $p['id'] ?>&quiz_id=<?= $quiz_id ?>" 
                                           class="delete-link" 
                                           onclick="return confirm('Deseja realmente excluir esta pergunta?')">Excluir</a>
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