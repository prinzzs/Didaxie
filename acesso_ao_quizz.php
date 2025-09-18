<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Protegido</title>
    <link rel="stylesheet" href="css/acessoaoquizz.css">
</head>
<body>
    <div class="container" id="loginScreen">
        <div class="icon-container">
            <svg class="lock-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        
        <h1>Quiz Protegido</h1>
        <p class="subtitle">Digite a senha para acessar o quiz</p>

        <div class="form-group">
            <label for="password">Senha de Acesso</label>
            <div class="password-container">
                <input type="password" id="password" placeholder="Digite sua senha...">
                <button type="button" class="eye-button" id="togglePassword">
                    <svg class="eye-icon" id="eyeIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="error-message" id="errorMessage">
            <svg class="error-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span id="errorText">Senha incorreta. Tente novamente.</span>
        </div>

        <button class="submit-btn" id="submitBtn" onclick="handleSubmit()">
            <span id="btnText">Acessar Quiz</span>
        </button>

        <p class="help-text">
            Não possui a senha? Entre em contato com o seu professor.
        </p>
    </div>

    <div class="success-screen" id="successScreen">
        <div class="container success-container">
            <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            
            <h1>Acesso Liberado!</h1>
            <p class="subtitle">Parabéns! Você está autorizado a realizar o quiz.</p>
            
            <button class="start-quiz-btn" onclick="startQuiz()">
                Iniciar Quiz
            </button>
        </div>
    </div>
    <script src="js/acessoaoquiz.js"></script>
</body>
</html>