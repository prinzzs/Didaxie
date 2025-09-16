<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogos Online e Presenciais - Guia de Instruções</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: clamp(15px, 3vw, 30px);
        }
        
        header {
            text-align: center;
            margin-bottom: clamp(30px, 5vw, 50px);
            background: rgba(255, 255, 255, 0.95);
            padding: clamp(20px, 4vw, 40px);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
        
        header h1 {
            color: #4a5568;
            font-size: clamp(2rem, 5vw, 3rem);
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        header p {
            color: #718096;
            font-size: clamp(1rem, 2.5vw, 1.3rem);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .game-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(100%, 380px), 1fr));
            gap: clamp(20px, 3vw, 30px);
            margin-bottom: 30px;
            align-items: start;
        }
        
        .game-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: clamp(20px, 4vw, 30px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: fit-content;
            display: flex;
            flex-direction: column;
        }
        
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .game-title {
            color: #2d3748;
            font-size: clamp(1.2rem, 3vw, 1.6rem);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            line-height: 1.3;
        }
        
        .game-icon {
            width: clamp(32px, 5vw, 40px);
            height: clamp(32px, 5vw, 40px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(1.1rem, 3vw, 1.3rem);
            flex-shrink: 0;
        }
        
        .ice-breaker { background: linear-gradient(45deg, #ff6b6b, #ffa726); }
        .collaboration { background: linear-gradient(45deg, #4ecdc4, #44a08d); }
        .energizer { background: linear-gradient(45deg, #f093fb, #f5576c); }
        .educational { background: linear-gradient(45deg, #4facfe, #00f2fe); }
        .creative { background: linear-gradient(45deg, #fa709a, #fee140); }
        
        .game-meta {
            display: flex;
            flex-wrap: wrap;
            gap: clamp(8px, 2vw, 15px);
            margin-bottom: 15px;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
            color: #666;
            align-items: center;
        }
        
        .meta-item {
            background: #f7fafc;
            padding: clamp(4px, 1vw, 8px) clamp(8px, 2vw, 12px);
            border-radius: 15px;
            border: 1px solid #e2e8f0;
            white-space: nowrap;
            font-weight: 500;
        }
        
        .game-description {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: clamp(0.9rem, 2.2vw, 1.1rem);
            line-height: 1.5;
        }
        
        .instructions {
            background: #f8f9fa;
            border-radius: 10px;
            padding: clamp(12px, 3vw, 18px);
            margin-bottom: 15px;
        }
        
        .instructions h4 {
            color: #2d3748;
            margin-bottom: 12px;
            font-size: clamp(1rem, 2.5vw, 1.15rem);
            font-weight: 600;
        }
        
        .instructions ol, .instructions ul {
            padding-left: clamp(16px, 4vw, 24px);
            color: #4a5568;
        }
        
        .instructions li {
            margin-bottom: 8px;
            line-height: 1.4;
            font-size: clamp(0.85rem, 2vw, 1rem);
        }
        
        .adaptations {
            background: #e6fffa;
            border-left: 4px solid #38b2ac;
            padding: clamp(12px, 3vw, 18px);
            border-radius: 0 10px 10px 0;
        }
        
        .adaptations h4 {
            color: #2c7a7b;
            margin-bottom: 10px;
            font-size: clamp(1rem, 2.5vw, 1.15rem);
            font-weight: 600;
        }
        
        .mode-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: clamp(8px, 2vw, 12px);
            margin-bottom: 18px;
        }
        
        .mode-tab {
            background: #e2e8f0;
            border: none;
            padding: clamp(6px, 1.5vw, 10px) clamp(12px, 3vw, 18px);
            border-radius: 20px;
            cursor: pointer;
            font-size: clamp(0.8rem, 2vw, 0.95rem);
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .mode-tab.active {
            background: #667eea;
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }
        
        .mode-tab:hover:not(.active) {
            background: #cbd5e0;
        }
        
        .mode-content {
            display: none;
        }
        
        .mode-content.active {
            display: block;
        }
        
        .tips {
            background: #fff5cd;
            border-radius: 10px;
            padding: clamp(12px, 3vw, 18px);
            margin-top: 15px;
            border-left: 4px solid #f6ad55;
        }
        
        .tips h4 {
            color: #c05621;
            margin-bottom: 10px;
            font-size: clamp(1rem, 2.5vw, 1.15rem);
            font-weight: 600;
        }
        
        .tips ul {
            padding-left: clamp(16px, 4vw, 20px);
        }
        
        .tips li {
            margin-bottom: 6px;
            line-height: 1.4;
            font-size: clamp(0.85rem, 2vw, 1rem);
        }
        
        /* Enhanced Mobile Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .game-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .game-card {
                padding: 20px;
            }
            
            .mode-tabs {
                justify-content: center;
            }
            
            .mode-tab {
                flex: 1;
                text-align: center;
                min-width: 120px;
                max-width: 150px;
            }
            
            .game-meta {
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            header {
                padding: 20px 15px;
            }
            
            .game-title {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }
            
            .game-icon {
                align-self: center;
            }
            
            .mode-tabs {
                flex-direction: column;
                align-items: stretch;
            }
            
            .mode-tab {
                max-width: none;
            }
        }
        
        /* Large screen optimization */
        @media (min-width: 1400px) {
            .game-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🎮 Jogos Interativos</h1>
            <p>Instruções completas para jogos que funcionam online e presencialmente</p>
        </header>
        
        <div class="game-grid">
            <!-- Quebra-Gelo: Duas Verdades e Uma Mentira -->
            <div class="game-card">
                <div class="game-title">
                    <div class="game-icon ice-breaker">❄️</div>
                    Duas Verdades e Uma Mentira
                </div>
                <div class="game-meta">
                    <span class="meta-item">⏱️ 15-20 min</span>
                    <span class="meta-item">👥 3-30 pessoas</span>
                    <span class="meta-item">🎯 Quebra-gelo</span>
                </div>
                <div class="game-description">
                    Um clássico para conhecer melhor os participantes de forma divertida e surpreendente.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-1')">📍 Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-1')">💻 Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-1">
                    <div class="instructions">
                        <h4>📋 Instruções Presencial:</h4>
                        <ol>
                            <li>Cada pessoa escreve três frases sobre si: duas verdadeiras e uma falsa</li>
                            <li>Uma por vez, lê suas frases em voz alta</li>
                            <li>O grupo tenta adivinhar qual é a mentira</li>
                            <li>Após os palpites, a pessoa revela a resposta e explica as verdades</li>
                        </ol>
                    </div>
                </div>
                
                <div class="mode-content" id="online-1">
                    <div class="instructions">
                        <h4>💻 Instruções Online:</h4>
                        <ol>
                            <li>Use chat ou compartilhamento de tela para apresentar as frases</li>
                            <li>Participantes podem votar usando reações ou chat</li>
                            <li>Use breakout rooms para grupos menores</li>
                            <li>Mantenha um ritmo dinâmico para manter o engajamento</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>💡 Dicas:</h4>
                    <ul>
                        <li>Incentive fatos únicos e interessantes</li>
                        <li>Estabeleça um tempo limite por pessoa (2-3 min)</li>
                        <li>Permita perguntas de esclarecimento</li>
                    </ul>
                </div>
            </div>

            <!-- Colaboração: Construção de História -->
            <div class="game-card">
                <div class="game-title">
                    <div class="game-icon collaboration">📚</div>
                    Construção Colaborativa de História
                </div>
                <div class="game-meta">
                    <span class="meta-item">⏱️ 20-30 min</span>
                    <span class="meta-item">👥 5-25 pessoas</span>
                    <span class="meta-item">🎯 Colaboração</span>
                </div>
                <div class="game-description">
                    Desenvolve criatividade e trabalho em equipe através da criação coletiva de narrativas.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-2')">📍 Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-2')">💻 Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-2">
                    <div class="instructions">
                        <h4>📋 Instruções Presencial:</h4>
                        <ol>
                            <li>Sente em círculo ou use quadro/flipchart</li>
                            <li>Primeira pessoa inicia com uma frase</li>
                            <li>Cada pessoa adiciona uma frase seguindo a história</li>
                            <li>Continue até todos participarem 2-3 vezes</li>
                            <li>Leiam a história completa no final</li>
                        </ol>
                    </div>
                </div>
                
                <div class="mode-content" id="online-2">
                    <div class="instructions">
                        <h4>💻 Instruções Online:</h4>
                        <ol>
                            <li>Use documento compartilhado (Google Docs, Miro)</li>
                            <li>Estabeleça ordem de participação no chat</li>
                            <li>Cada pessoa digita uma frase por vez</li>
                            <li>Use timer para manter ritmo (30-60 segundos)</li>
                            <li>Compartilhe tela para ler história final</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>💡 Dicas:</h4>
                    <ul>
                        <li>Defina tema ou deixe livre</li>
                        <li>Regra: não negar o que foi dito antes</li>
                        <li>Incentive reviradas na trama</li>
                    </ul>
                </div>
            </div>

            <!-- Energizador: Mímica Express -->
            <div class="game-card">
                <div class="game-title">
                    <div class="game-icon energizer">🎭</div>
                    Mímica Express
                </div>
                <div class="game-meta">
                    <span class="meta-item">⏱️ 10-15 min</span>
                    <span class="meta-item">👥 6-50 pessoas</span>
                    <span class="meta-item">🎯 Energizador</span>
                </div>
                <div class="game-description">
                    Ativa o grupo e quebra a monotonia através de expressão corporal e diversão.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-3')">📍 Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-3')">💻 Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-3">
                    <div class="instructions">
                        <h4>📋 Instruções Presencial:</h4>
                        <ol>
                            <li>Prepare cartas com palavras/conceitos</li>
                            <li>Divida em duas equipes</li>
                            <li>Uma pessoa de cada vez faz mímica (60 segundos)</li>
                            <li>Equipe tenta adivinhar</li>
                            <li>Conte pontos e declare vencedor</li>
                        </ol>
                    </div>
                </div>
                
                <div class="mode-content" id="online-3">
                    <div class="instructions">
                        <h4>💻 Instruções Online:</h4>
                        <ol>
                            <li>Envie palavra por mensagem privada</li>
                            <li>Pessoa liga câmera e faz mímica</li>
                            <li>Outros respondem no chat</li>
                            <li>Use breakout rooms para equipes</li>
                            <li>Facilitador conta pontos</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>💡 Dicas:</h4>
                    <ul>
                        <li>Escolha palavras relacionadas ao contexto</li>
                        <li>Permita mímica com sons (sem palavras)</li>
                        <li>Tenha palavras fáceis e difíceis</li>
                    </ul>
                </div>
            </div>

            <!-- Educacional: Quiz Colaborativo -->
            <div class="game-card">
                <div class="game-title">
                    <div class="game-icon educational">🧠</div>
                    Quiz Colaborativo
                </div>
                <div class="game-meta">
                    <span class="meta-item">⏱️ 25-40 min</span>
                    <span class="meta-item">👥 8-40 pessoas</span>
                    <span class="meta-item">🎯 Educacional</span>
                </div>
                <div class="game-description">
                    Reforça conteúdo através de perguntas e respostas em formato colaborativo e competitivo.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-4')">📍 Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-4')">💻 Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-4">
                    <div class="instructions">
                        <h4>📋 Instruções Presencial:</h4>
                        <ol>
                            <li>Divida em equipes de 3-5 pessoas</li>
                            <li>Prepare perguntas de múltipla escolha</li>
                            <li>Equipes discutem e escrevem respostas</li>
                            <li>Revele respostas e explique conceitos</li>
                            <li>Some pontos e celebre aprendizado</li>
                        </ol>
                    </div>
                </div>
                
                <div class="mode-content" id="online-4">
                    <div class="instructions">
                        <h4>💻 Instruções Online:</h4>
                        <ol>
                            <li>Use Kahoot, Mentimeter ou similares</li>
                            <li>Crie breakout rooms para discussão</li>
                            <li>Equipes voltam e respondem juntas</li>
                            <li>Compartilhe tela com resultados</li>
                            <li>Discuta respostas incorretas</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>💡 Dicas:</h4>
                    <ul>
                        <li>Misture perguntas fáceis e desafiadoras</li>
                        <li>Dê tempo para discussão em equipe</li>
                        <li>Explique o "porquê" das respostas</li>
                    </ul>
                </div>
            </div>

            <!-- Criativo: Brainstorm Visual -->
            <div class="game-card">
                <div class="game-title">
                    <div class="game-icon creative">🎨</div>
                    Brainstorm Visual
                </div>
                <div class="game-meta">
                    <span class="meta-item">⏱️ 30-45 min</span>
                    <span class="meta-item">👥 4-20 pessoas</span>
                    <span class="meta-item">🎯 Criativo</span>
                </div>
                <div class="game-description">
                    Estimula criatividade através de desenhos e associações visuais para resolver problemas.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-5')">📍 Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-5')">💻 Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-5">
                    <div class="instructions">
                        <h4>📋 Instruções Presencial:</h4>
                        <ol>
                            <li>Distribua papel e canetas/canetinhas</li>
                            <li>Apresente problema ou desafio</li>
                            <li>10 min: cada um desenha ideias silenciosamente</li>
                            <li>Compartilhem desenhos em pequenos grupos</li>
                            <li>Grupo seleciona melhores ideias para apresentar</li>
                        </ol>
                    </div>
                </div>
                
                <div class="mode-content" id="online-5">
                    <div class="instructions">
                        <h4>💻 Instruções Online:</h4>
                        <ol>
                            <li>Use Miro, Jamboard ou similar</li>
                            <li>Crie template com área para cada pessoa</li>
                            <li>Breakout rooms para desenho individual</li>
                            <li>Retornem e apresentem criações</li>
                            <li>Vote nas ideias mais criativas</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>💡 Dicas:</h4>
                    <ul>
                        <li>Enfatize que não precisa ser "bom" desenho</li>
                        <li>Encoraje ideias "malucas"</li>
                        <li>Combine ideias de diferentes pessoas</li>
                    </ul>
                </div>
            </div>

            <!-- Reflexivo: Linha do Tempo de Aprendizado -->
            <div class="game-card">
                <div class="game-title">
                    <div class="game-icon educational">⏰</div>
                    Linha do Tempo de Aprendizado
                </div>
                <div class="game-meta">
                    <span class="meta-item">⏱️ 20-35 min</span>
                    <span class="meta-item">👥 5-30 pessoas</span>
                    <span class="meta-item">🎯 Reflexivo</span>
                </div>
                <div class="game-description">
                    Promove reflexão sobre o processo de aprendizado e conquistas pessoais ou do grupo.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-6')">📍 Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-6')">💻 Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-6">
                    <div class="instructions">
                        <h4>📋 Instruções Presencial:</h4>
                        <ol>
                            <li>Desenhe linha do tempo grande no quadro/papel</li>
                            <li>Marque momentos-chave (início do curso, marcos importantes)</li>
                            <li>Cada pessoa adiciona post-its com aprendizados</li>
                            <li>Incluam desafios superados e conquistas</li>
                            <li>Compartilhem reflexões em grupo</li>
                        </ol>
                    </div>
                </div>
                
                <div class="mode-content" id="online-6">
                    <div class="instructions">
                        <h4>💻 Instruções Online:</h4>
                        <ol>
                            <li>Crie linha do tempo em ferramenta visual</li>
                            <li>Cada pessoa adiciona seus marcos</li>
                            <li>Use cores diferentes por pessoa</li>
                            <li>Breakout rooms para discussões menores</li>
                            <li>Apresentem principais insights para todos</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>💡 Dicas:</h4>
                    <ul>
                        <li>Inclua marcos emocionais, não só técnicos</li>
                        <li>Permita marcos futuros (objetivos)</li>
                        <li>Celebre progressos pequenos e grandes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchMode(button, contentId) {
            // Remove active class from all tabs in this card
            const card = button.closest('.game-card');
            const tabs = card.querySelectorAll('.mode-tab');
            const contents = card.querySelectorAll('.mode-content');
            
            tabs.forEach(tab => tab.classList.remove('active'));
            contents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            button.classList.add('active');
            document.getElementById(contentId).classList.add('active');
        }
        
        // Add some interactive elements
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Add ripple effect
                if (!e.target.closest('.mode-tab')) {
                    this.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                }
            });
        });
    </script>
</body>
</html>