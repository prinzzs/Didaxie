<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuração da conexão
$servername = "localhost";
$username = "root"; 
$password = "usbw";     
$dbname = "didaxie";

$message = "";
$messageType = "";

try {
    // Conectar direto ao banco já existente
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Falha na conexão: " . $conn->connect_error);
    }

    // Processar cadastro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['ano'])) {
            throw new Exception("Todos os campos são obrigatórios!");
        }
        
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $ano = $_POST['ano'];
        
        if (strlen($nome) < 2) throw new Exception("O nome deve ter pelo menos 2 caracteres!");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email inválido!");
        if (strlen($senha) < 6) throw new Exception("A senha deve ter pelo menos 6 caracteres!");
        
        $anosValidos = [
            '1º Ano Fundamental', '2º Ano Fundamental', '3º Ano Fundamental', 
            '4º Ano Fundamental', '5º Ano Fundamental', '6º Ano Fundamental', 
            '7º Ano Fundamental', '8º Ano Fundamental', '9º Ano Fundamental',
            '1º Ano Ensino Médio', '2º Ano Ensino Médio', '3º Ano Ensino Médio',
            'EJA'
        ];
        
        if (!in_array($ano, $anosValidos)) {
            throw new Exception("Ano/série selecionado é inválido!");
        }
        
        // Verificar se email já existe
        $stmt = $conn->prepare("SELECT id FROM professores WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) throw new Exception("Email já cadastrado!");
        $stmt->close();
        
        // Inserir novo professor
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO professores (nome, email, senha, ano) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senhaHash, $ano);
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
    if (isset($conn)) $conn->close();
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Didaxie - Cadastro Professor</title>
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
            margin-top: 15px;
        }
        .login-link:hover {
            opacity: 0.8;
        }
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background-color: white;
        }
        select:focus {
            outline: none;
            border-color: #007bff;
        }
        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DIDAXIE</h1>
        <h2>CADASTRO PROFESSOR</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div> 
        <?php endif; ?>

        <form method="POST" action="cadastro_professor.php">
            <input placeholder="Nome completo:" type="text" name="nome" maxlength="100" required />
            <input placeholder="Email:" type="email" name="email" maxlength="100" required />
            <input placeholder="Senha:" type="password" name="senha" minlength="6" required />

            <label for="ano">Ano escolar/série:</label>
            <select name="ano" id="ano" required>
                <option value="" disabled selected>Selecione o ano/série</option>
                <optgroup label="Ensino Fundamental">
                    <option value="1º Ano Fundamental">1º Ano do Fundamental</option>
                    <option value="2º Ano Fundamental">2º Ano do Fundamental</option>
                    <option value="3º Ano Fundamental">3º Ano do Fundamental</option>
                    <option value="4º Ano Fundamental">4º Ano do Fundamental</option>
                    <option value="5º Ano Fundamental">5º Ano do Fundamental</option>
                    <option value="6º Ano Fundamental">6º Ano do Fundamental</option>
                    <option value="7º Ano Fundamental">7º Ano do Fundamental</option>
                    <option value="8º Ano Fundamental">8º Ano do Fundamental</option>
                    <option value="9º Ano Fundamental">9º Ano do Fundamental</option>
                </optgroup>
                <optgroup label="Ensino Médio">
                    <option value="1º Ano Ensino Médio">1º Ano do Ensino Médio</option>
                    <option value="2º Ano Ensino Médio">2º Ano do Ensino Médio</option>
                    <option value="3º Ano Ensino Médio">3º Ano do Ensino Médio</option>
                </optgroup>
                <optgroup label="Educação de Jovens e Adultos">
                    <option value="EJA">EJA</option>
                </optgroup>
            </select>

            <button type="submit">Cadastrar</button>
        </form>

        <p class="login-link" onclick="window.location.href='login.php'">JÁ TENHO UMA CONTA</p>
    </div>
</body>
</html>
