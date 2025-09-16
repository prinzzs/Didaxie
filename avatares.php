<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTRODUCING - Character Selection</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&family=Orbitron:wght@400;700;900&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-red: #ff4655;
            --primary-red-dark: #cc3644;
            --primary-red-light: #ff7a85;
            --bg-dark: #0f0f0f;
            --bg-medium: #1a1a1a;
            --bg-light: #2a2a2a;
            --text-white: #ffffff;
            --text-gray: #999999;
            --text-dark-gray: #666666;
            --border-opacity: 0.3;
            --transition-fast: 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-medium: 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --transition-slow: 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --shadow-glow: 0 0 25px rgba(255, 70, 85, 0.3);
            --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        html {
            font-size: 16px;
        }

        body {
            font-family: 'Rajdhani', sans-serif;
            min-height: 100vh;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                repeating-linear-gradient(
                    0deg,
                    var(--bg-medium) 0px,
                    var(--bg-medium) 2px,
                    var(--bg-light) 2px,
                    var(--bg-light) 4px
                ),
                repeating-linear-gradient(
                    90deg,
                    var(--bg-medium) 0px,
                    var(--bg-medium) 2px,
                    var(--bg-light) 2px,
                    var(--bg-light) 4px
                ),
                linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-medium) 50%, var(--bg-dark) 100%);
            background-size: 30px 30px, 30px 30px, 100% 100%;
            background-attachment: fixed;
            color: var(--text-white);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 1rem;
            position: relative;
        }

        .main-container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            min-height: 100vh;
            padding: 1rem 0;
        }

        /* === HEADER === */
        .header {
            text-align: center;
            width: 100%;
            max-width: 800px;
            margin-bottom: 1rem;
        }

        .logo-section {
            margin-bottom: 1rem;
        }

        .logo-icon {
            width: 4rem;
            height: 4rem;
            background: linear-gradient(45deg, var(--primary-red), var(--primary-red-dark));
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            font-weight: bold;
            clip-path: polygon(20% 0%, 80% 0%, 100% 20%, 100% 80%, 80% 100%, 20% 100%, 0% 80%, 0% 20%);
            transition: all var(--transition-medium);
        }

        .logo-icon:hover {
            transform: rotate(10deg) scale(1.05);
            box-shadow: var(--shadow-glow);
        }

        .main-title {
            font-family: 'Orbitron', monospace;
            font-size: 3.25rem;
            font-weight: 900;
            color: var(--text-white);
            margin: 0.75rem 0 0.5rem;
            letter-spacing: 0.5rem;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
            line-height: 1.1;
            background: linear-gradient(45deg, var(--text-white), var(--primary-red-light));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            font-size: 1.25rem;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.25rem;
            font-weight: 300;
            line-height: 1.3;
        }

        .roster-subtitle {
            color: var(--primary-red);
            font-weight: 600;
        }

        /* === CHARACTERS GRID === */
        .characters-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }

        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            width: 100%;
            max-width: 800px;
            justify-items: center;
            align-items: stretch;
        }

        .character-slot {
            background: linear-gradient(180deg, rgba(40, 40, 40, 0.9) 0%, rgba(20, 20, 20, 0.95) 100%);
            border: 2px solid rgba(255, 70, 85, var(--border-opacity));
            width: 100%;
            max-width: 320px;
            min-width: 280px;
            aspect-ratio: 3/4;
            position: relative;
            cursor: pointer;
            transition: all var(--transition-medium);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .character-slot:hover {
            border-color: var(--primary-red);
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-hover), var(--shadow-glow);
        }

        .character-slot:active {
            transform: translateY(-4px) scale(1.01);
            transition: all 0.1s ease;
        }

        .character-slot.selected {
            border-color: var(--primary-red);
            background: linear-gradient(180deg, rgba(255, 70, 85, 0.15) 0%, rgba(40, 40, 40, 0.95) 100%);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 
                0 15px 35px rgba(0, 0, 0, 0.5),
                0 0 30px rgba(255, 70, 85, 0.4);
        }

        .character-slot.selected:hover {
            transform: translateY(-10px) scale(1.03);
        }

        .character-image {
            width: 100%;
            flex: 1;
            background: linear-gradient(180deg, rgba(60, 60, 60, 0.8) 0%, rgba(30, 30, 30, 0.9) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .character-silhouette {
            width: 8rem;
            height: 10rem;
            background: linear-gradient(180deg, #666 0%, #333 100%);
            position: relative;
            transition: all var(--transition-fast);
        }

        .character-silhouette.female {
            clip-path: polygon(
                40% 0%, 60% 0%, 65% 15%, 70% 25%, 
                65% 40%, 70% 55%, 65% 70%, 60% 85%, 
                55% 100%, 45% 100%, 40% 85%, 35% 70%, 
                30% 55%, 35% 40%, 30% 25%, 35% 15%
            );
        }

        .character-silhouette.male {
            clip-path: polygon(
                35% 0%, 65% 0%, 70% 10%, 75% 25%, 
                70% 40%, 80% 55%, 75% 70%, 70% 85%, 
                65% 100%, 35% 100%, 30% 85%, 25% 70%, 
                20% 55%, 30% 40%, 25% 25%, 30% 10%
            );
        }

        .character-slot.selected .character-silhouette {
            background: linear-gradient(180deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            filter: drop-shadow(0 0 10px rgba(255, 70, 85, 0.6));
            transform: scale(1.1);
        }

        .character-info {
            padding: 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            min-height: 120px;
            background: rgba(0, 0, 0, 0.3);
        }

        .character-name {
            font-family: 'Orbitron', monospace;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-white);
            text-transform: uppercase;
            letter-spacing: 0.125rem;
            line-height: 1.2;
        }

        .character-role {
            font-size: 0.95rem;
            color: var(--primary-red);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }

        .character-description {
            font-size: 0.8rem;
            color: var(--text-gray);
            line-height: 1.4;
            text-align: center;
            padding: 0 0.5rem;
        }

        .player-label {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            background: var(--primary-red);
            color: white;
            padding: 0.3rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            border-radius: 4px;
        }

        .player-number {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.8);
            color: var(--primary-red);
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
            font-family: 'Orbitron', monospace;
            border-radius: 50%;
            border: 2px solid rgba(255, 70, 85, 0.5);
        }

        .selection-indicator {
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border: 3px solid var(--primary-red);
            border-radius: 12px;
            opacity: 0;
            transition: opacity var(--transition-fast);
            pointer-events: none;
        }

        .character-slot.selected .selection-indicator {
            opacity: 1;
            animation: selectedGlow 1.5s ease-in-out infinite alternate;
        }

        @keyframes selectedGlow {
            from { box-shadow: 0 0 10px rgba(255, 70, 85, 0.6); }
            to { box-shadow: 0 0 20px rgba(255, 70, 85, 0.9); }
        }

        /* === SELECTION DISPLAY === */
        .selection-display {
            padding: 1.5rem 2rem;
            background: rgba(255, 70, 85, 0.1);
            border: 1px solid rgba(255, 70, 85, var(--border-opacity));
            border-radius: 8px;
            text-align: center;
            display: none;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
        }

        .selection-display.show {
            display: block;
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .selected-info {
            font-size: 1.125rem;
            color: var(--text-white);
            line-height: 1.4;
        }

        .selected-name {
            font-family: 'Orbitron', monospace;
            font-size: 1.625rem;
            color: var(--primary-red);
            font-weight: 700;
            margin: 0.75rem 0;
            line-height: 1.2;
        }

        /* === BOTTOM INFO === */
        .bottom-info {
            text-align: center;
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            margin-top: auto;
        }

        .sponsors {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            opacity: 0.6;
            flex-wrap: wrap;
        }

        .sponsor {
            font-family: 'Orbitron', monospace;
            font-size: 0.875rem;
            color: var(--text-dark-gray);
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
        }

        .continue-btn {
            background: linear-gradient(45deg, var(--primary-red), var(--primary-red-dark));
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
            font-weight: 700;
            font-family: 'Rajdhani', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.125rem;
            cursor: pointer;
            transition: all var(--transition-fast);
            opacity: 0.4;
            pointer-events: none;
            position: relative;
            overflow: hidden;
            min-width: 250px;
            width: 100%;
            max-width: 320px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .continue-btn.active {
            opacity: 1;
            pointer-events: all;
            cursor: pointer;
        }

        .continue-btn:hover.active {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(255, 70, 85, 0.4);
            background: linear-gradient(45deg, var(--primary-red-light), var(--primary-red));
        }

        .continue-btn:active.active {
            transform: translateY(0) scale(0.98);
            transition: all 0.1s ease;
        }

        .continue-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .continue-btn:hover.active::before {
            left: 100%;
        }

        .continue-btn:disabled {
            cursor: not-allowed;
            opacity: 0.4;
        }

        /* === RESPONSIVE DESIGN === */

        /* Tablets (768px - 1024px) */
        @media (max-width: 1024px) {
            html {
                font-size: 15px;
            }

            .main-container {
                gap: 1.5rem;
                padding: 0.5rem 0;
            }
            
            .characters-grid {
                gap: 1.5rem;
                max-width: 700px;
            }

            .main-title {
                font-size: 2.8rem;
                letter-spacing: 0.4rem;
            }
        }

        /* Mobile Large (481px - 767px) */
        @media (max-width: 767px) {
            html {
                font-size: 14px;
            }

            body {
                padding: 0.75rem;
            }
            
            .main-container {
                gap: 1.25rem;
                min-height: auto;
            }

            .header {
                margin-bottom: 0.5rem;
            }
            
            .characters-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                max-width: 350px;
            }
            
            .character-slot {
                width: 100%;
                max-width: 100%;
                min-width: 280px;
                aspect-ratio: 4/5;
            }

            .main-title {
                font-size: 2.2rem;
                letter-spacing: 0.25rem;
            }

            .subtitle {
                font-size: 1rem;
                letter-spacing: 0.15rem;
            }

            .sponsors {
                flex-direction: column;
                gap: 0.5rem;
            }

            .continue-btn {
                min-width: 220px;
                max-width: 100%;
                padding: 0.875rem 2rem;
                font-size: 1rem;
            }
        }

        /* Mobile Medium (361px - 480px) */
        @media (max-width: 480px) {
            html {
                font-size: 13px;
            }

            .main-container {
                gap: 1rem;
            }
            
            .character-slot {
                min-width: 260px;
                aspect-ratio: 3/4;
            }

            .main-title {
                font-size: 1.8rem;
                letter-spacing: 0.15rem;
            }

            .logo-icon {
                width: 3rem;
                height: 3rem;
                font-size: 1.5rem;
            }

            .character-silhouette {
                width: 6rem;
                height: 8rem;
            }

            .continue-btn {
                min-width: 200px;
                padding: 0.75rem 1.5rem;
            }
        }

        /* Mobile Small (320px - 360px) */
        @media (max-width: 360px) {
            html {
                font-size: 12px;
            }

            body {
                padding: 0.5rem;
            }
            
            .character-slot {
                min-width: 240px;
            }

            .main-title {
                font-size: 1.5rem;
                letter-spacing: 0.1rem;
                word-break: break-word;
                hyphens: auto;
            }

            .character-info {
                padding: 1rem;
                min-height: 100px;
            }

            .continue-btn {
                min-width: 180px;
                font-size: 0.9rem;
            }
        }

        /* Ultra-wide screens */
        @media (min-width: 1400px) {
            .characters-grid {
                gap: 3rem;
                grid-template-columns: repeat(2, minmax(320px, 350px));
            }

            .character-slot {
                max-width: 350px;
            }
        }

        /* Landscape mobile */
        @media (max-height: 700px) and (orientation: landscape) {
            .main-container {
                gap: 1rem;
                padding: 0.5rem 0;
                justify-content: flex-start;
                min-height: auto;
            }
            
            .header {
                margin-bottom: 0.5rem;
            }

            .main-title {
                font-size: 2rem;
                margin: 0.5rem 0;
            }
            
            .character-slot {
                aspect-ratio: 2/3;
            }
            
            .characters-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.5rem;
                max-width: 600px;
            }

            .bottom-info {
                gap: 1rem;
                margin-top: 0.5rem;
            }
        }

        /* Very short screens */
        @media (max-height: 500px) {
            .main-container {
                gap: 0.75rem;
                justify-content: flex-start;
            }
            
            .character-slot {
                aspect-ratio: 1/1.2;
                min-height: 180px;
            }

            .main-title {
                font-size: 1.5rem;
            }

            .character-info {
                min-height: 80px;
                padding: 0.75rem;
            }
        }

        /* High DPI screens */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .logo-icon {
                border: 0.5px solid rgba(255, 255, 255, 0.2);
            }
            
            .character-slot {
                border-width: 1.5px;
            }
        }

        /* Touch devices */
        @media (hover: none) and (pointer: coarse) {
            .character-slot {
                transition: all 0.2s ease;
            }

            .character-slot:hover {
                transform: none;
            }

            .character-slot:active {
                transform: scale(0.98);
                opacity: 0.8;
            }

            .continue-btn:hover.active {
                transform: none;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            }
        }

        /* Accessibility - Reduced motion */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.1s !important;
            }

            .character-slot:hover,
            .character-slot.selected {
                transform: none !important;
            }

            .continue-btn:hover.active {
                transform: none !important;
            }
        }

        /* Dark mode adjustments */
        @media (prefers-color-scheme: light) {
            :root {
                --text-gray: #777777;
                --text-dark-gray: #555555;
            }
        }

        /* Focus styles for accessibility */
        .character-slot:focus {
            outline: 2px solid var(--primary-red);
            outline-offset: 4px;
        }

        .continue-btn:focus {
            outline: 2px solid var(--primary-red);
            outline-offset: 2px;
        }

        /* Screen reader only */
        .sr-only {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            border: 0 !important;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <header class="header">
            <div class="logo-section">
                <div class="logo-icon">⚡</div>
            </div>
            <h1 class="main-title">INTRODUCING</h1>
            <p class="subtitle">OUR <span class="roster-subtitle">ROSTER</span> FOR QUIZ</p>
        </header>

        <section class="characters-container">
            <div class="characters-grid">
                <!-- Personagem Feminino -->
                <article class="character-slot" data-character="female" onclick="selectCharacter('female', 1)" role="button" tabindex="0" aria-label="Selecionar Viper">
                    <div class="selection-indicator"></div>
                    <div class="player-number" aria-hidden="true">01</div>
                    <div class="character-image">
                        <div class="character-silhouette female"></div>
                    </div>
                    <div class="character-info">
                        <h3 class="character-name">VIPER</h3>
                        <div class="character-role">Controlador</div>
                        <p class="character-description">Especialista em controle tático</p>
                    </div>
                    <div class="player-label">PLAYER</div>
                </article>

                <!-- Personagem Masculino -->
                <article class="character-slot" data-character="male" onclick="selectCharacter('male', 2)" role="button" tabindex="0" aria-label="Selecionar Phoenix">
                    <div class="selection-indicator"></div>
                    <div class="player-number" aria-hidden="true">02</div>
                    <div class="character-image">
                        <div class="character-silhouette male"></div>
                    </div>
                    <div class="character-info">
                        <h3 class="character-name">PHOENIX</h3>
                        <div class="character-role">Duelista</div>
                        <p class="character-description">Combatente agressivo</p>
                    </div>
                    <div class="player-label">PLAYER</div>
                </article>
            </div>
        </section>

        <aside class="selection-display" id="selectionDisplay" role="status" aria-live="polite">
            <div class="selected-info">AGENTE SELECIONADO</div>
            <div class="selected-name" id="selectedName"></div>
            <div id="selectedDetails"></div>
        </aside>

        <footer class="bottom-info">
            <div class="sponsors">
                <span class="sponsor">QUIZ GAMING</span>
                <span class="sponsor" aria-hidden="true">•</span>
                <span class="sponsor">TACTICAL</span>
                <span class="sponsor" aria-hidden="true">•</span>
                <span class="sponsor">SAMX</span>
            </div>
            
            <button class="continue-btn" id="continueBtn" onclick="startMission()" disabled aria-describedby="selection-status">
                INICIAR MISSÃO
            </button>
        </footer>
    </div>

    <script>
        let selectedCharacter = null;
        let selectedPlayerNumber = null;

        const characters = {
            female: {
                name: "VIPER",
                role: "Controlador",
                description: "Agente especialista em controle de área e guerra química tática"
            },
            male: {
                name: "PHOENIX",
                role: "Duelista", 
                description: "Combatente agressivo com habilidades de regeneração e ataque"
            }
        };

        function selectCharacter(characterType, playerNumber) {
            // Remove seleção anterior
            document.querySelectorAll('.character-slot').forEach(slot => {
                slot.classList.remove('selected');
                slot.setAttribute('aria-selected', 'false');
            });

            // Adiciona seleção ao slot clicado
            const selectedSlot = document.querySelector(`[data-character="${characterType}"]`);
            selectedSlot.classList.add('selected');
            selectedSlot.setAttribute('aria-selected', 'true');

            // Atualiza variáveis
            selectedCharacter = characterType;
            selectedPlayerNumber = playerNumber;

            // Mostra informações da seleção
            updateSelectionDisplay(characterType);

            // Ativa botão
            const continueBtn = document.getElementById('continueBtn');
            continueBtn.classList.add('active');
            continueBtn.disabled = false;
            continueBtn.removeAttribute('aria-disabled');

            // Efeito visual
            createSelectionEffect(selectedSlot);

            // Announce selection for screen readers
            announceSelection(characters[characterType]);
        }

        function updateSelectionDisplay(characterType) {
            const character = characters[characterType];
            const display = document.getElementById('selectionDisplay');
            const nameElement = document.getElementById('selectedName');
            const detailsElement = document.getElementById('selectedDetails');

            nameElement.textContent = character.name;
            detailsElement.textContent = `${character.role} • ${character.description}`;
            
            display.classList.add('show');
        }

        function createSelectionEffect(slot) {
            // Efeito de destaque suave
            const currentTransform = slot.style.transform || '';
            slot.style.transform = 'translateY(-12px) scale(1.05)';
            
            setTimeout(() => {
                if (slot.classList.contains('selected')) {
                    slot.style.transform = 'translateY(-5px) scale(1.02)';
                } else {
                    slot.style.transform = currentTransform;
                }
            }, 200);
        }

        function announceSelection(character) {
            // Create announcement for screen readers
            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', 'assertive');
            announcement.setAttribute('aria-atomic', 'true');
            announcement.className = 'sr-only';
            announcement.textContent = `${character.name} selecionado. ${character.role}. ${character.description}`;
            document.body.appendChild(announcement);
            
            setTimeout(() => {
                if (document.body.contains(announcement)) {
                    document.body.removeChild(announcement);
                }
            }, 1000);
        }

        function startMission() {
            if (!selectedCharacter) {
                alert('Por favor, selecione um personagem primeiro!');
                return;
            }

            const character = characters[selectedCharacter];
            
            const confirmed = confirm(
                `═══════════════════════════════\n` +
                `    CONFIRMAÇÃO DE AGENTE     \n` +
                `═══════════════════════════════\n\n` +
                `PLAYER ${selectedPlayerNumber}: ${character.name}\n` +
                `ROLE: ${character.role}\n\n` +
                `Iniciar missão?`
            );

            if (confirmed) {
                // Salva seleção (usando variável temporária em vez de localStorage)
                window.selectedAgent = {
                    type: selectedCharacter,
                    playerNumber: selectedPlayerNumber,
                    ...character
                };
                
                // Feedback visual
                const continueBtn = document.getElementById('continueBtn');
                const originalText = continueBtn.textContent;
                continueBtn.textContent = 'CONECTANDO...';
                continueBtn.disabled = true;
                continueBtn.classList.remove('active');

                // Simula carregamento
                setTimeout(() => {
                    alert(`MISSÃO INICIADA!\n\n${character.name} DEPLOYED\nPlayer ${selectedPlayerNumber} Ready\n\n[CONNECTING...]`);
                    
                    // Aqui você redirecionaria para o quiz
                    // window.location.href = 'quiz.html';
                    
                    // Reset do botão para demonstração
                    continueBtn.textContent = originalText;
                    continueBtn.disabled = false;
                    continueBtn.classList.add('active');
                }, 1500);
            }
        }

        // Suporte a teclado melhorado
        document.addEventListener('keydown', (e) => {
            if (e.target.classList.contains('character-slot')) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    e.target.click();
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                    e.preventDefault();
                    navigateCharacters(e.key === 'ArrowRight' ? 1 : -1);
                }
            } else if (e.target.id === 'continueBtn') {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    if (!e.target.disabled) {
                        e.target.click();
                    }
                }
            }
        });

        function navigateCharacters(direction) {
            const slots = Array.from(document.querySelectorAll('.character-slot'));
            const currentIndex = slots.findIndex(slot => slot === document.activeElement);
            
            let nextIndex;
            if (currentIndex === -1) {
                nextIndex = direction > 0 ? 0 : slots.length - 1;
            } else {
                nextIndex = (currentIndex + direction + slots.length) % slots.length;
            }
            
            slots[nextIndex].focus();
        }

        // Melhor gerenciamento de eventos de hover/touch
        document.querySelectorAll('.character-slot').forEach(slot => {
            let hoverTimeout;
            
            slot.addEventListener('mouseenter', function() {
                clearTimeout(hoverTimeout);
                if (!this.classList.contains('selected')) {
                    this.style.transform = 'translateY(-8px) scale(1.02)';
                }
            });

            slot.addEventListener('mouseleave', function() {
                clearTimeout(hoverTimeout);
                hoverTimeout = setTimeout(() => {
                    if (!this.classList.contains('selected')) {
                        this.style.transform = 'translateY(0) scale(1)';
                    }
                }, 100);
            });

            // Touch events for mobile
            slot.addEventListener('touchstart', function(e) {
                e.preventDefault();
                this.style.transform = 'scale(0.98)';
            }, { passive: false });

            slot.addEventListener('touchend', function(e) {
                e.preventDefault();
                setTimeout(() => {
                    if (this.classList.contains('selected')) {
                        this.style.transform = 'translateY(-5px) scale(1.02)';
                    } else {
                        this.style.transform = 'translateY(0) scale(1)';
                    }
                }, 100);
                this.click();
            }, { passive: false });
        });

        // Botão continue com melhor feedback
        const continueBtn = document.getElementById('continueBtn');
        
        continueBtn.addEventListener('mouseenter', function() {
            if (this.classList.contains('active')) {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            }
        });

        continueBtn.addEventListener('mouseleave', function() {
            if (this.classList.contains('active')) {
                this.style.transform = 'translateY(0) scale(1)';
            }
        });

        continueBtn.addEventListener('mousedown', function() {
            if (this.classList.contains('active')) {
                this.style.transform = 'translateY(0) scale(0.98)';
            }
        });

        continueBtn.addEventListener('mouseup', function() {
            if (this.classList.contains('active')) {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            }
        });

        // Animação de entrada melhorada com Intersection Observer
        window.addEventListener('load', () => {
            const slots = document.querySelectorAll('.character-slot');
            const header = document.querySelector('.header');
            const bottomInfo = document.querySelector('.bottom-info');
            
            // Observer para animações de entrada
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0) scale(1)';
                        }, entry.target.dataset.delay || 0);
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            // Preparar elementos para animação
            [header, ...slots, bottomInfo].forEach((element, index) => {
                if (element) {
                    element.style.opacity = '0';
                    element.style.transform = 'translateY(30px)';
                    element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                    element.dataset.delay = index * 150;
                    observer.observe(element);
                }
            });
        });

        // Otimização de performance para resize
        let resizeTimer;
        let isResizing = false;
        
        window.addEventListener('resize', () => {
            if (!isResizing) {
                isResizing = true;
                requestAnimationFrame(() => {
                    // Recalcular layouts se necessário
                    updateLayoutOnResize();
                    isResizing = false;
                });
            }
            
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                console.log('Layout optimized after resize');
            }, 250);
        });

        function updateLayoutOnResize() {
            // Força recálculo de layout apenas se necessário
            const slots = document.querySelectorAll('.character-slot');
            slots.forEach(slot => {
                if (slot.classList.contains('selected')) {
                    // Garante que a transformação está correta após resize
                    slot.style.transform = 'translateY(-5px) scale(1.02)';
                }
            });
        }

        // Prevenção de scroll bounce em iOS
        document.addEventListener('touchmove', function(e) {
            if (e.target.closest('.character-slot, .continue-btn')) {
                e.preventDefault();
            }
        }, { passive: false });

        // Feedback haptico em dispositivos compatíveis
        function provideFeedback() {
            if ('vibrate' in navigator) {
                navigator.vibrate(50); // Vibração suave de 50ms
            }
        }

        // Adicionar feedback haptico aos cliques
        document.querySelectorAll('.character-slot').forEach(slot => {
            slot.addEventListener('click', provideFeedback);
        });

        continueBtn.addEventListener('click', function() {
            if (this.classList.contains('active')) {
                provideFeedback();
            }
        });

        // Gerenciamento de estado da aplicação
        const appState = {
            selectedCharacter: null,
            selectedPlayerNumber: null,
            isLoading: false,
            
            updateSelection(character, playerNumber) {
                this.selectedCharacter = character;
                this.selectedPlayerNumber = playerNumber;
                this.saveToSession();
            },
            
            saveToSession() {
                // Usando variável de sessão em vez de localStorage
                window.gameSession = {
                    character: this.selectedCharacter,
                    playerNumber: this.selectedPlayerNumber,
                    timestamp: Date.now()
                };
            },
            
            loadFromSession() {
                if (window.gameSession) {
                    this.selectedCharacter = window.gameSession.character;
                    this.selectedPlayerNumber = window.gameSession.playerNumber;
                    return true;
                }
                return false;
            }
        };

        // Inicialização da aplicação
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Character Selection Screen Loaded');
            
            // Tenta carregar sessão anterior (para demonstração)
            appState.loadFromSession();
            
            // Adiciona listeners para eventos de visibilidade
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') {
                    console.log('App became visible');
                } else {
                    console.log('App became hidden');
                }
            });
        });
    </script>
</body>
</html>