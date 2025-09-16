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
            padding-top: 70px;
        }
        
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            color: #4a5568;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 1);
        }
        
        .back-arrow {
            width: 18px;
            height: 18px;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%234a5568" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
        }
        
        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: clamp(12px, 2.5vw, 30px);
        }
        
        header {
            text-align: center;
            margin-bottom: clamp(25px, 4vw, 50px);
            background: rgba(255, 255, 255, 0.95);
            padding: clamp(20px, 4vw, 45px);
            border-radius: clamp(15px, 3vw, 25px);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
        
        header h1 {
            color: #4a5568;
            font-size: clamp(1.8rem, 4.5vw, 3.2rem);
            margin-bottom: clamp(10px, 2vw, 18px);
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        header p {
            color: #718096;
            font-size: clamp(0.9rem, 2.2vw, 1.4rem);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.5;
        }
        
        .game-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 350px), 1fr));
            gap: clamp(18px, 3.5vw, 35px);
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
            width: clamp(36px, 6vw, 48px);
            height: clamp(36px, 6vw, 48px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background-size: 70%;
            background-repeat: no-repeat;
            background-position: center;
        }
        
        .ice-breaker { 
            background: linear-gradient(45deg, #ffc1cc, #ffb3d1);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 12 3-3 3 3-3 3z"/><path d="m17 12 3-3 3 3-3 3z"/><path d="m12 2 3 3-3 3-3-3z"/><path d="M12 17l3 3-3 3-3-3z"/></svg>');
        }
        .collaboration { 
            background: linear-gradient(45deg, #b8e6d3, #a8d8ea);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="m22 21v-2a4 4 0 0 0-3-3.87"/><path d="m16 3.13a4 4 0 0 1 0 7.75"/></svg>');
        }
        .energizer { 
            background: linear-gradient(45deg, #f8b4cb, #fdd5d5);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m13 2-2 2.5h3L12 7"/><path d="M10 14v-3"/><path d="M14 14v-3"/><path d="M11 19c-1.7 0-3-1.3-3-3v-2h8v2c0 1.7-1.3 3-3 3z"/><path d="M12 22v-3"/></svg>');
        }
        .educational { 
            background: linear-gradient(45deg, #b8e0ff, #c8e6ff);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.07 2.07 0 0 1-2.44-2.44 2.07 2.07 0 0 1-2.44-2.44 2.07 2.07 0 0 1-2.44-2.44A2.5 2.5 0 0 1 2.5 9.5v-5c0-.28.22-.5.5-.5s.5.22.5.5v5a1.5 1.5 0 0 0 3 0V4.5A2.5 2.5 0 0 1 9.5 2z"/><path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.07 2.07 0 0 0 2.44-2.44 2.07 2.07 0 0 0 2.44-2.44 2.07 2.07 0 0 0 2.44-2.44A2.5 2.5 0 0 0 21.5 9.5v-5c0-.28-.22-.5-.5-.5s-.5.22-.5.5v5a1.5 1.5 0 0 1-3 0V4.5A2.5 2.5 0 0 0 14.5 2z"/></svg>');
        }
        .creative { 
            background: linear-gradient(45deg, #ffd1dc, #ffe4b5);
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>');
        }
        
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
        @media (max-width: 1024px) {
            .game-grid {
                grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr));
                gap: clamp(15px, 3vw, 25px);
            }
        }
        
        @media (max-width: 768px) {
            body {
                padding-top: 80px;
            }
            
            .back-button {
                top: 15px;
                left: 15px;
                padding: 10px 16px;
                font-size: 14px;
            }
            
            .container {
                padding: clamp(10px, 2vw, 20px);
            }
            
            .game-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .game-card {
                padding: clamp(15px, 3vw, 25px);
            }
            
            .game-title {
                font-size: clamp(1.1rem, 4vw, 1.4rem);
            }
            
            .mode-tabs {
                justify-content: center;
                gap: 8px;
            }
            
            .mode-tab {
                flex: 1;
                text-align: center;
                min-width: 100px;
                max-width: 140px;
                padding: 8px 12px;
                font-size: 0.9rem;
            }
            
            .game-meta {
                justify-content: flex-start;
                gap: 8px;
            }
            
            .meta-item {
                font-size: 0.8rem;
                padding: 4px 8px;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding-top: 85px;
            }
            
            .back-button {
                top: 10px;
                left: 10px;
                padding: 8px 12px;
                font-size: 13px;
                border-radius: 20px;
            }
            
            .back-arrow {
                width: 16px;
                height: 16px;
            }
            
            header {
                padding: 15px;
                border-radius: 15px;
            }
            
            header h1 {
                font-size: clamp(1.6rem, 6vw, 2.2rem);
            }
            
            header p {
                font-size: clamp(0.85rem, 3.5vw, 1.1rem);
            }
            
            .game-card {
                padding: 15px;
            }
            
            .game-title {
                flex-direction: row;
                align-items: center;
                text-align: left;
                gap: 10px;
                font-size: 1.2rem;
            }
            
            .game-icon {
                width: 32px;
                height: 32px;
            }
            
            .mode-tabs {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            
            .mode-tab {
                max-width: none;
                padding: 10px 16px;
                font-size: 0.9rem;
            }
            
            .instructions {
                padding: 12px;
            }
            
            .instructions ol, .instructions ul {
                padding-left: 18px;
            }
            
            .instructions li {
                font-size: 0.9rem;
                margin-bottom: 6px;
            }
            
            .game-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
            
            .meta-item {
                align-self: flex-start;
            }
        }
        
        @media (max-width: 360px) {
            .container {
                padding: 8px;
            }
            
            .game-card {
                padding: 12px;
                border-radius: 12px;
            }
            
            header {
                padding: 12px;
            }
            
            .instructions {
                padding: 10px;
            }
            
            .tips {
                padding: 10px;
            }
        }
        
        /* Large screen optimization */
        @media (min-width: 1400px) {
            .game-grid {
                grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
                gap: 35px;
            }
        }
        
        @media (min-width: 1800px) {
            .container {
                max-width: 1800px;
            }
            
            .game-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="goBack()">
        <div class="back-arrow"></div>
        Voltar
    </button>
    
    <div class="container">
        <header>
            <h1>Jogos Interativos</h1>
            <p>Instruções completas para jogos que funcionam online e presencialmente</p>
        </header>
        
        <div class="game-grid">
            <!-- Quebra-Gelo: Duas Verdades e Uma Mentira -->
            <div class="game-card">
                <div class="game-title">
                    <div class="game-icon ice-breaker"></div>
                    Duas Verdades e Uma Mentira
                </div>
                <div class="game-meta">
                    <span class="meta-item">Tempo: 15-20 min</span>
                    <span class="meta-item">Pessoas: 3-30</span>
                    <span class="meta-item">Tipo: Quebra-gelo</span>
                </div>
                <div class="game-description">
                    Um clássico para conhecer melhor os participantes de forma divertida e surpreendente.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-1')">Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-1')">Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-1">
                    <div class="instructions">
                        <h4>Instruções Presencial:</h4>
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
                        <h4>Instruções Online:</h4>
                        <ol>
                            <li>Use chat ou compartilhamento de tela para apresentar as frases</li>
                            <li>Participantes podem votar usando reações ou chat</li>
                            <li>Use breakout rooms para grupos menores</li>
                            <li>Mantenha um ritmo dinâmico para manter o engajamento</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>Dicas:</h4>
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
                    <div class="game-icon collaboration"></div>
                    Construção Colaborativa de História
                </div>
                <div class="game-meta">
                    <span class="meta-item">Tempo: 20-30 min</span>
                    <span class="meta-item">Pessoas: 5-25</span>
                    <span class="meta-item">Tipo: Colaboração</span>
                </div>
                <div class="game-description">
                    Desenvolve criatividade e trabalho em equipe através da criação coletiva de narrativas.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-2')">Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-2')">Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-2">
                    <div class="instructions">
                        <h4>Instruções Presencial:</h4>
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
                        <h4>Instruções Online:</h4>
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
                    <h4>Dicas:</h4>
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
                    <div class="game-icon energizer"></div>
                    Mímica Express
                </div>
                <div class="game-meta">
                    <span class="meta-item">Tempo: 10-15 min</span>
                    <span class="meta-item">Pessoas: 6-50</span>
                    <span class="meta-item">Tipo: Energizador</span>
                </div>
                <div class="game-description">
                    Ativa o grupo e quebra a monotonia através de expressão corporal e diversão.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-3')">Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-3')">Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-3">
                    <div class="instructions">
                        <h4>Instruções Presencial:</h4>
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
                        <h4>Instruções Online:</h4>
                        <ol>
                            <li>Envie palavra por mensagem privada</li>
                            <li>Pessoa liga câmera and faz mímica</li>
                            <li>Outros respondem no chat</li>
                            <li>Use breakout rooms para equipes</li>
                            <li>Facilitador conta pontos</li>
                        </ol>
                    </div>
                </div>
                
                <div class="tips">
                    <h4>Dicas:</h4>
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
                    <div class="game-icon educational"></div>
                    Quiz Colaborativo
                </div>
                <div class="game-meta">
                    <span class="meta-item">Tempo: 25-40 min</span>
                    <span class="meta-item">Pessoas: 8-40</span>
                    <span class="meta-item">Tipo: Educacional</span>
                </div>
                <div class="game-description">
                    Reforça conteúdo através de perguntas e respostas em formato colaborativo e competitivo.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-4')">Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-4')">Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-4">
                    <div class="instructions">
                        <h4>Instruções Presencial:</h4>
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
                        <h4>Instruções Online:</h4>
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
                    <h4>Dicas:</h4>
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
                    <div class="game-icon creative"></div>
                    Brainstorm Visual
                </div>
                <div class="game-meta">
                    <span class="meta-item">Tempo: 30-45 min</span>
                    <span class="meta-item">Pessoas: 4-20</span>
                    <span class="meta-item">Tipo: Criativo</span>
                </div>
                <div class="game-description">
                    Estimula criatividade através de desenhos e associações visuais para resolver problemas.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-5')">Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-5')">Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-5">
                    <div class="instructions">
                        <h4>Instruções Presencial:</h4>
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
                        <h4>Instruções Online:</h4>
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
                    <h4>Dicas:</h4>
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
                    <div class="game-icon educational"></div>
                    Linha do Tempo de Aprendizado
                </div>
                <div class="game-meta">
                    <span class="meta-item">Tempo: 20-35 min</span>
                    <span class="meta-item">Pessoas: 5-30</span>
                    <span class="meta-item">Tipo: Reflexivo</span>
                </div>
                <div class="game-description">
                    Promove reflexão sobre o processo de aprendizado e conquistas pessoais ou do grupo.
                </div>
                
                <div class="mode-tabs">
                    <button class="mode-tab active" onclick="switchMode(this, 'presencial-6')">Presencial</button>
                    <button class="mode-tab" onclick="switchMode(this, 'online-6')">Online</button>
                </div>
                
                <div class="mode-content active" id="presencial-6">
                    <div class="instructions">
                        <h4>Instruções Presencial:</h4>
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
                        <h4>Instruções Online:</h4>
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
                    <h4>Dicas:</h4>
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
        
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                // Se não há histórico, pode redirecionar para uma página inicial ou fechar
                window.close();
            }
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
        
        // Smooth scroll behavior for better UX
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>