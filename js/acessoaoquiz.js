// Senha correta (em uma aplicação real, isso seria validado no backend)
        let isLoading = false;

        // Elementos do DOM
        const passwordInput = document.getElementById('password');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');
        const errorMessage = document.getElementById('errorMessage');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const loginScreen = document.getElementById('loginScreen');
        const successScreen = document.getElementById('successScreen');

        // Toggle mostrar/esconder senha
        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Muda o ícone
            if (type === 'text') {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        });

        // Permitir submit com Enter
        passwordInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !isLoading) {
                handleSubmit();
            }
        });

        // Esconder erro quando usuário digita
        passwordInput.addEventListener('input', function() {
            errorMessage.style.display = 'none';
        });

        // Função para lidar com o submit
        async function handleSubmit() {
            if (isLoading) return;

            const password = passwordInput.value.trim();
            if (!password) {
                showError("Digite o código do quiz.");
                return;
            }

            setLoading(true);
            hideError();

            try {
                const formData = new FormData();
                formData.append('action', 'verify_quiz_code'); // nova ação
                formData.append('codigo', password);

                const response = await fetch('api.php', { 
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.ok) {
                    showSuccess();
                    setTimeout(() => {
                        window.location.href = `cadastro_aluno.php?codigo=${data.codigo}`;
                    }, 1000);
                } else {
                    showError(data.error || 'Código inválido');
                    passwordInput.value = '';
                    passwordInput.focus();
                }

            } catch (err) {
                showError('Erro de conexão com o servidor.');
                console.error(err);
            } finally {
                setLoading(false);
            }
        }

        // Função para mostrar estado de loading
        function setLoading(loading) {
            isLoading = loading;
            if (loading) {
                submitBtn.disabled = true;
                btnText.innerHTML = `
                    <div class="spinner"></div>
                    Verificando...
                `;
            } else {
                submitBtn.disabled = false;
                btnText.textContent = "Acessar Quiz";
            }
        }

        // Função para mostrar erro
        function showError(message) {
            document.getElementById('errorText').textContent = message;
            errorMessage.style.display = 'flex';
        }

        // Função para esconder erro
        function hideError() {
            errorMessage.style.display = 'none';
        }

        // Função para mostrar tela de sucesso
        function showSuccess() {
            document.body.style.background = 'linear-gradient(135deg, #10b981, #059669, #047857)';
            loginScreen.style.display = 'none';
            successScreen.style.display = 'flex';
        }

        // Função para iniciar o quiz
        function startQuiz() {
            alert("Iniciando o quiz...");
            window.location.href = `cadastro_aluno.php?codigo=${data.codigo}`;
        }

        // Foco inicial no campo de senha
        window.addEventListener('load', () => {
            passwordInput.focus();
        });