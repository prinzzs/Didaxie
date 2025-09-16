<?php
session_start();

// Configuração da conexão
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "didaxie";

$codigo = $_GET['codigo'] ?? '';

$message = "";
$messageType = "";

try {
    // Conectar ao MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão: " . $conn->connect_error);
    }

    // Criar tabela alunos se não existir
    $sql = "CREATE TABLE IF NOT EXISTS alunos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        usuario VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    if (!$conn->query($sql)) {
        throw new Exception("Erro ao criar tabela: " . $conn->error);
    }

    // Processar cadastro
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = trim($_POST['nome'] ?? '');
        $usuario = trim($_POST['usuario'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        // Validações
        if (!$nome || !$usuario || !$email || !$senha) throw new Exception("Todos os campos são obrigatórios!");
        if (strlen($nome) < 2) throw new Exception("O nome deve ter pelo menos 2 caracteres!");
        if (strlen($usuario) < 3) throw new Exception("O nome de usuário deve ter pelo menos 3 caracteres!");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email inválido!");
        if (strlen($senha) < 6) throw new Exception("A senha deve ter pelo menos 6 caracteres!");

        // Verificar se já existe
        $stmt = $conn->prepare("SELECT id FROM alunos WHERE usuario = ? OR email = ?");
        $stmt->bind_param("ss", $usuario, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) throw new Exception("Usuário ou email já cadastrados!");
        $stmt->close();

        // Inserir aluno
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO alunos (nome, usuario, email, senha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $usuario, $email, $senhaHash);

        if ($stmt->execute()) {
            // Cadastro OK → redirecionar para login mantendo o código
            header("Location: login_aluno.php?codigo=" . urlencode($codigo));
            exit;
        } else {
            throw new Exception("Erro ao cadastrar: " . $stmt->error);
        }
        $stmt->close();
    }

} catch (Exception $e) {
    $message = $e->getMessage();
    $messageType = "error";
} finally {
    if (isset($conn)) $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Didaxie - Cadastro Aluno</title>
    <link rel="stylesheet" href="css/fontes.css">
    <link rel="stylesheet" href="css/cadastroProf.css">
    <style>
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .login-link {
            cursor: pointer;
            text-decoration: underline;
        }
        .login-link:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DIDAXIE</h1>
        <h2>CADASTRO ALUNOS</h2>
        
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="cadastro_aluno.php?codigo=<?= urlencode($codigo) ?>">
            <input placeholder="Nome completo:" type="text" name="nome" maxlength="100" required />
            <input placeholder="Nome de usuário:" type="text" name="usuario" maxlength="50" required />
            <input placeholder="Email:" type="email" name="email" maxlength="100" required />
            <input placeholder="Senha:" type="password" name="senha" minlength="6" required />
            <button type="submit">Cadastrar</button>
        </form>

        <p class="login-link">
            <a href="login_aluno.php?codigo=<?= urlencode($codigo) ?>">JÁ TENHO UMA CONTA</a>
        </p>
    </div>
</body>
</html>