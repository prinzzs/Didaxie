<?php
session_start();

// Configuração da conexão
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "didaxie";

$message = "";
$messageType = "";

try {
    // Conectar já no banco existente
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");

    if ($conn->connect_error) {
        throw new Exception("Falha na conexão: " . $conn->connect_error);
    }

    // Processar login
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validar se todos os campos foram preenchidos
        if (empty($_POST['email']) || empty($_POST['senha'])) {
            throw new Exception("Todos os campos são obrigatórios!");
        }

        $email = trim($_POST['email']);
        $senha = $_POST['senha'];

        // Validação básica do email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido!");
        }

        // Buscar professor no banco
        $stmt = $conn->prepare("SELECT id, nome, email, senha, ano FROM professores WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verificar senha
            if (password_verify($senha, $user['senha'])) {
                // Login bem-sucedido - guardar sessão
                $_SESSION['professor_id'] = $user['id'];
                $_SESSION['professor_nome'] = $user['nome'];
                $_SESSION['professor_email'] = $user['email'];
                $_SESSION['professor_ano'] = $user['ano'];
                $_SESSION['tipo'] = "professor";

                // Redirecionar para o painel
                header("Location: painel_professor.php");
                exit();
            } else {
                throw new Exception("Senha incorreta!");
            }
        } else {
            throw new Exception("Email não cadastrado!");
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
    <title>Didaxie - Login Professor</title>
    <link rel="stylesheet" href="css/fontes.css">
    <link rel="stylesheet" href="css/loginProfessor.css">
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
        .register-link {
            cursor: pointer;
            text-decoration: underline;
            margin-top: 15px;
            display: block;
            text-align: center;
        }
        .register-link:hover {
            opacity: 0.8;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px 0;
        }
        button:hover {
            background-color: #0056b3;
        }
        button:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>DIDAXIE</h1>
        <h2>LOGIN PROFESSOR</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST" action="login_professor.php" id="loginForm">
                <input placeholder="Email:" type="email" name="email" maxlength="100" required />
                <input placeholder="Senha:" type="password" name="senha" minlength="6" required />
                <button type="submit" id="submitBtn">Entrar</button>
            </form>

            <p class="register-link" onclick="window.location.href='cadastro_professor.php'">NÃO TENHO UMA CONTA</p>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.textContent = 'Entrando...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>