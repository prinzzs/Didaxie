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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Respostas - Questão <?= $questao_id ?></title>
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
            max-width: calc(100vw - 380px);
            padding: 20px;
            overflow-y: auto;
        }

        /* Container principal */
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
            font-size: 32px;
            font-weight: 400;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .question-preview {
            background: rgba(255,255,255,.15);
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }

        .question-preview-title {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            opacity: 0.8;
            margin-bottom: 12px;
        }

        .question-text {
            font-size: 18px;
            line-height: 1.5;
        }

        /* Conteúdo do formulário */
        .form-content {
            padding: 32px;
        }

        /* Navegação de volta */
        .back-nav {
            margin-bottom: 32px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #673ab7;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            padding: 12px 20px;
            border-radius: 24px;
            transition: all 0.2s ease;
            border: 1px solid rgba(103,58,183,.2);
        }

        .back-link:hover {
            background-color: rgba(103,58,183,.1);
            border-color: rgba(103,58,183,.3);
        }

        .back-link::before {
            content: '←';
            margin-right: 10px;
            font-size: 18px;
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

        /* Card de adicionar resposta */
        .add-response-card {
            background: white;
            border: 1px solid #e8eaed;
            border-radius: 12px;
            padding: 32px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,.08);
            transition: box-shadow 0.3s ease;
        }

        .add-response-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,.12);
        }

        /* Formulário */
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

        .form-group input[type="text"] {
            width: 100%;
            padding: 20px;
            border: 2px solid #dadce0;
            border-radius: 8px;
            font-family: inherit;
            font-size: 16px;
            transition: border-color 0.2s ease;
            background-color: #fafafa;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #673ab7;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(103,58,183,.1);
        }

        /* Checkbox customizado */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 0;
        }

        .custom-checkbox {
            position: relative;
            display: inline-block;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            width: 24px;
            height: 24px;
        }

        .checkbox-design {
            width: 24px;
            height: 24px;
            border: 2px solid #dadce0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            background-color: white;
        }

        .custom-checkbox input[type="checkbox"]:checked + .checkbox-design {
            background-color: #673ab7;
            border-color: #673ab7;
        }

        .custom-checkbox input[type="checkbox"]:checked + .checkbox-design::after {
            content: '✓';
            color: white;
            font-size: 16px;
            font-weight: bold;
        }

        .checkbox-label {
            font-size: 16px;
            font-weight: 500;
            color: #5f6368;
            cursor: pointer;
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

        /* Cards de resposta */
        .resposta {
            background: white;
            border: 1px solid #e8eaed;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .resposta:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,.1);
            border-color: #dadce0;
            transform: translateY(-2px);
        }

        .resposta.correct {
            border-left: 4px solid #4caf50;
            background: linear-gradient(90deg, rgba(76,175,80,.08) 0%, white 25%);
        }

        .resposta.incorrect {
            border-left: 4px solid #f44336;
            background: linear-gradient(90deg, rgba(244,67,54,.08) 0%, white 25%);
        }

        .response-id {
            background: #f1f3f4;
            color: #5f6368;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 500;
            min-width: 50px;
            text-align: center;
        }

        .response-text {
            flex-grow: 1;
            font-size: 18px;
            line-height: 1.5;
        }

        .response-status {
            font-size: 15px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .response-status.correct {
            background: rgba(76,175,80,.12);
            color: #2e7d32;
        }

        .response-status.incorrect {
            background: rgba(244,67,54,.12);
            color: #c62828;
        }

        /* Links de ação */
        .actions {
            display: flex;
            gap: 16px;
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
            
            .question-text {
                font-size: 16px;
            }
            
            .form-content {
                padding: 20px;
            }
            
            .section-title {
                font-size: 20px;
            }
            
            .add-response-card,
            .resposta {
                padding: 20px;
            }

            .resposta {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .actions {
                width: 100%;
                justify-content: space-between;
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
            
            .add-response-card,
            .resposta {
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

        .resposta,
        .add-response-card {
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

        /* Melhorias de foco para acessibilidade */
        *:focus {
            outline: 2px solid #673ab7;
            outline-offset: 2px;
        }

        input[type="text"]:focus,
        input[type="checkbox"]:focus + .checkbox-design {
            outline: none;
            border-color: #673ab7;
            box-shadow: 0 0 0 4px rgba(103,58,183,.1);
        }
    </style>
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
                                        <a href="editarRespostaUnica.php?id=<?= $r['id'] ?>&questao_id=<?= $questao_id ?>">Editar</a>
                                        <a href="deletarResposta.php?id=<?= $r['id'] ?>&questao_id=<?= $questao_id ?>" 
                                           class="delete-link" 
                                           onclick="return confirm('Deseja realmente excluir esta resposta?')">Excluir</a>
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