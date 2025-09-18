<?php
session_start();

// Configuração da conexão
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "didaxie";

$codigo = $_GET['codigo'] ?? '';

$message = "";
$messageType = "";

try {
    // Conectar ao banco
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) throw new Exception("Falha na conexão: " . $conn->connect_error);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $codigoPost = $_POST['codigo'] ?? $codigo; // mantém o código enviado pelo POST ou GET

        if (!$email || !$senha) throw new Exception("Todos os campos são obrigatórios!");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email inválido!");

        $stmt = $conn->prepare("SELECT id, nome, usuario, senha FROM alunos WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) {
                // Login bem-sucedido
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_username'] = $user['usuario'];
                $_SESSION['usuario_email'] = $email;
                $_SESSION['tipo'] = "aluno";

                // Redirecionar para o jogo com o código
                header("Location: jogo1.php?codigo=" . urlencode($codigoPost));
                exit;
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
    if (isset($conn)) $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Didaxie - Login Aluno</title>
<link rel="stylesheet" href="css/fontes.css">
<link rel="stylesheet" href="css/loginProfessor.css">
<style>
.message { padding:10px; margin:10px 0; border-radius:5px; text-align:center; }
.message.success { background-color:#d4edda; color:#155724; border:1px solid #c3e6cb; }
.message.error { background-color:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
.login-link { cursor:pointer; text-decoration:underline; }
.login-link:hover { opacity:0.8; }
</style>
</head>
<body>
<div class="container">
    <h1>DIDAXIE</h1>
    <h2>LOGIN ALUNO</h2>

    <?php if (!empty($message)): ?>
        <div class="message <?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="login_aluno.php?codigo=<?= urlencode($codigo) ?>" id="loginForm">
        <input type="hidden" name="codigo" value="<?= htmlspecialchars($codigo) ?>">
        <input placeholder="Email:" type="email" name="email" maxlength="100" required>
        <input placeholder="Senha:" type="password" name="senha" minlength="6" required>
        <button type="submit" id="submitBtn">Login</button>
    </form>

    <p class="login-link">
        <a href="cadastro_aluno.php?codigo=<?= urlencode($codigo) ?>">NÃO TENHO UMA CONTA</a>
    </p>
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
