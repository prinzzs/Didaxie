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
            padding: 20px;
        }

        /* Container principal */
        .container {
            max-width: 768px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,.3), 0 2px 6px 2px rgba(60,64,67,.15);
            overflow: hidden;
        }

        /* Cabeçalho do formulário */
        .form-header {
            background: linear-gradient(135deg, #673ab7 0%, #512da8 100%);
            padding: 24px;
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
            font-size: 28px;
            font-weight: 400;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .question-preview {
            background: rgba(255,255,255,.15);
            padding: 16px;
            border-radius: 8px;
            margin-top: 16px;
            position: relative;
            z-index: 1;
        }

        .question-preview-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-bottom: 8px;
        }

        .question-text {
            font-size: 16px;
            line-height: 1.5;
        }

        /* Conteúdo do formulário */
        .form-content {
            padding: 24px;
        }

        /* Navegação de volta */
        .back-nav {
            margin-bottom: 24px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            color: #673ab7;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.2s ease;
            border: 1px solid rgba(103,58,183,.2);
        }

        .back-link:hover {
            background-color: rgba(103,58,183,.1);
            border-color: rgba(103,58,183,.3);
        }

        .back-link::before {
            content: '←';
            margin-right: 8px;
            font-size: 16px;
        }

        /* Seções */
        .section {
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 500;
            color: #202124;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e8eaed;
        }

        /* Card de adicionar resposta */
        .add-response-card {
            background: white;
            border: 1px solid #e8eaed;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
            transition: box-shadow 0.2s ease;
        }

        .add-response-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        /* Formulário */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #5f6368;
            margin-bottom: 8px;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 16px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            font-family: inherit;
            font-size: 16px;
            transition: border-color 0.2s ease;
            background-color: #fafafa;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #673ab7;
            background-color: white;
            box-shadow: inset 0 1px 2px rgba(103,58,183,.1);
        }

        /* Checkbox customizado */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
        }

        .custom-checkbox {
            position: relative;
            display: inline-block;
        }

        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            position: absolute;
            width: 20px;
            height: 20px;
        }

        .checkbox-design {
            width: 20px;
            height: 20px;
            border: 2px solid #dadce0;
            border-radius: 4px;
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
            font-size: 14px;
            font-weight: bold;
        }

        .checkbox-label {
            font-size: 14px;
            font-weight: 500;
            color: #5f6368;
            cursor: pointer;
        }

        /* Botões */
        .botao {
            background-color: #673ab7;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 24px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .botao:hover {
            background-color: #5e35b1;
            box-shadow: 0 2px 8px rgba(103,58,183,.3);
            transform: translateY(-1px);
        }

        .botao:active {
            transform: translateY(0);
            box-shadow: 0 1px 4px rgba(103,58,183,.3);
        }

        /* Cards de resposta */
        .resposta {
            background: white;
            border: 1px solid #e8eaed;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 16px;
            position: relative;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .resposta:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,.1);
            border-color: #dadce0;
        }

        .resposta.correct {
            border-left: 4px solid #4caf50;
            background: linear-gradient(90deg, rgba(76,175,80,.05) 0%, white 20%);
        }

        .resposta.incorrect {
            border-left: 4px solid #f44336;
            background: linear-gradient(90deg, rgba(244,67,54,.05) 0%, white 20%);
        }

        .response-id {
            background: #f1f3f4;
            color: #5f6368;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            min-width: 40px;
            text-align: center;
        }

        .response-text {
            flex-grow: 1;
            font-size: 16px;
            line-height: 1.5;
        }

        .response-status {
            font-size: 14px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .response-status.correct {
            background: rgba(76,175,80,.1);
            color: #2e7d32;
        }

        .response-status.incorrect {
            background: rgba(244,67,54,.1);
            color: #c62828;
        }

        /* Links de ação */
        .actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .actions a {
            color: #673ab7;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 16px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .actions a:hover {
            background-color: rgba(103,58,183,.1);
            border-color: rgba(103,58,183,.2);
        }

        .actions a.delete-link {
            color: #d93025;
        }

        .actions a.delete-link:hover {
            background-color: rgba(217,48,37,.1);
            border-color: rgba(217,48,37,.2);
        }

        /* Estado vazio */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #5f6368;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            body {
                padding: 12px;
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

            .resposta {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .actions {
                width: 100%;
                justify-content: space-between;
            }
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .resposta,
        .add-response-card {
            animation: fadeIn 0.3s ease-out;
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
            box-shadow: 0 0 0 2px rgba(103,58,183,.2);
        }
    </style>
</head>
<body>
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
</body>
</html>