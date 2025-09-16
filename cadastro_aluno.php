<?php
// Configuração da conexão
$servername = "localhost";
$username = "root"; // usuário do XAMPP/Laragon
$password = "usbw";     // senha (normalmente em branco no XAMPP)
$dbname = "didaxie";

$message = "";
$messageType = "";

try {
    // Criar conexão inicial sem banco
    $conn = new mysqli($servername, $username, $password);
    
    // Checar conexão
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão: " . $conn->connect_error);
    }
    
    // Criar banco se não existir
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (!$conn->query($sql)) {
        throw new Exception("Erro ao criar banco: " . $conn->error);
    }
    
    // Selecionar banco
    $conn->select_db($dbname);
    
    // Criar tabela de alunos se não existir
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validar se todos os campos foram preenchidos
        if (empty($_POST['nome']) || empty($_POST['usuario']) || empty($_POST['email']) || empty($_POST['senha'])) {
            throw new Exception("Todos os campos são obrigatórios!");
        }
        
        $nome = trim($_POST['nome']);
        $usuario = trim($_POST['usuario']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        
        // Validações básicas
        if (strlen($nome) < 2) {
            throw new Exception("O nome deve ter pelo menos 2 caracteres!");
        }
        
        if (strlen($usuario) < 3) {
            throw new Exception("O nome de usuário deve ter pelo menos 3 caracteres!");
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido!");
        }
        
        if (strlen($senha) < 6) {
            throw new Exception("A senha deve ter pelo menos 6 caracteres!");
        }
        
        // Verificar se usuário ou email já existem
        $stmt = $conn->prepare("SELECT id FROM alunos WHERE usuario = ? OR email = ?");
        $stmt->bind_param("ss", $usuario, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            throw new Exception("Usuário ou email já cadastrados!");
        }
        $stmt->close();
        
        // Inserir novo aluno
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO alunos (nome, usuario, email, senha) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $usuario, $email, $senhaHash);
        
        if ($stmt->execute()) {
            $message = "Cadastro realizado com sucesso!";
            $messageType = "success";
        } else {
            throw new Exception("Erro ao cadastrar: " . $stmt->error);
        }
        
        $stmt->close();
    }
    
} catch (Exception $e) {
    $message = $e->getMessage();
    $messageType = "error";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
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
        
        <form method="POST" action="cadastro_aluno.php">
            <input placeholder="Nome completo:" type="text" name="nome" maxlength="100" required />
            <input placeholder="Nome de usuário:" type="text" name="usuario" maxlength="50" required />
            <input placeholder="Email:" type="email" name="email" maxlength="100" required />
            <input placeholder="Senha:" type="password" name="senha" minlength="6" required />
            <button type="submit">Cadastrar</button>
        </form>

        <p class="login-link" onclick="window.location.href='login.php'">JÁ TENHO UMA CONTA</p>
    </div>
</body>
</html>