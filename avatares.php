<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant - Agents</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        :root {
            --primary-bg: #0f0c19;
            --secondary-bg: #1a1529;
            --card-bg: #1e1830;
            --accent-color: #9b59b6;
            --accent-secondary: #8e44ad;
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.7);
            --border-color: #3a2c50;
            --shadow-glow: rgba(155, 89, 182, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(ellipse at top, #1a1529 0%, #0f0c19 70%);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 2rem;
            overflow-x: hidden;
            position: relative;
        }

        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--accent-color);
            border-radius: 50%;
            opacity: 0.05;
        }

        .play-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            height: 70px;
            padding: 0 1.5rem;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-radius: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 
                0 10px 30px rgba(0, 0, 0, 0.3),
                0 0 20px var(--shadow-glow);
            backdrop-filter: blur(20px);
        }

        .play-button::before {
            display: none;
        }

        .play-button:hover {
            transform: scale(1.1);
            box-shadow: 
                0 15px 40px rgba(0, 0, 0, 0.4),
                0 0 30px var(--shadow-glow);
        }

        .play-button:active {
            transform: scale(0.95);
        }

        .play-text {
            font-size: 1rem;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .play-icon {
            width: 0;
            height: 0;
            border-left: 20px solid #ffffff;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            margin-left: 4px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
            20%, 40%, 60%, 80% { transform: translateX(2px); }
        }

        .agents-section {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding: 0 0.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.2rem;
            position: relative;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }

        .filter-tab:hover {
            background: rgba(155, 89, 182, 0.1);
            border-color: var(--accent-color);
            color: var(--text-primary);
        }

        .filter-tab.active {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--text-primary);
        }

        .search-input {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-primary);
            outline: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 200px;
        }

        .search-input:focus {
            border-color: var(--accent-color);
            background: rgba(155, 89, 182, 0.1);
        }

        .search-input::placeholder {
            color: var(--text-secondary);
        }

        .agents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
            padding: 0 0.5rem;
        }

        .agent-card {
            background: linear-gradient(135deg, var(--card-bg) 0%, rgba(30, 24, 48, 0.8) 100%);
            border: 2px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            aspect-ratio: 3/4;
            backdrop-filter: blur(20px);
        }

        .agent-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, 
                transparent 30%, 
                rgba(155, 89, 182, 0.1) 50%, 
                transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .agent-card:hover::before {
            opacity: 1;
        }

        .agent-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: var(--accent-color);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.3),
                0 0 30px var(--shadow-glow),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .agent-card.selected {
            border-color: var(--accent-color);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.4),
                0 0 40px var(--shadow-glow),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transform: translateY(-8px) scale(1.02);
        }

        .agent-card.selected::after {
            display: none;
        }

        .agent-image {
            height: 75%;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at center, rgba(155, 89, 182, 0.1) 0%, transparent 70%);
        }

        .agent-portrait {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 20%;
            transition: all 0.4s ease;
            filter: brightness(0.9) contrast(1.1);
        }

        .agent-card:hover .agent-portrait {
            transform: scale(1.1);
            filter: brightness(1.1) contrast(1.2);
        }

        .agent-role-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.8);
            color: var(--accent-secondary);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(142, 68, 173, 0.3);
            z-index: 2;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .agent-card:hover .agent-role-badge {
            opacity: 1;
            transform: translateY(0);
        }

        .agent-info {
            height: 25%;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(0, 0, 0, 0.9);
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
        }

        .agent-name {
            font-size: 1.125rem;
            font-weight: 800;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.15rem;
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .agent-subtitle {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-align: center;
            font-weight: 500;
        }

        .agent-meta {
            background: linear-gradient(135deg, 
                rgba(155, 89, 182, 0.15) 0%, 
                rgba(142, 68, 173, 0.15) 100%);
            border: 1px solid rgba(155, 89, 182, 0.2);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(20px);
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .agent-meta::before {
            display: none;
        }

        .meta-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .meta-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
        }

        .meta-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .meta-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            padding: 1.25rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .stat-card.unlocked {
            opacity: 1;
            filter: grayscale(0);
        }

        .stat-card:not(.unlocked) {
            opacity: 0.5;
            filter: grayscale(0.7);
        }

        .stat-card:not(.unlocked)::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 2px,
                rgba(255, 255, 255, 0.02) 2px,
                rgba(255, 255, 255, 0.02) 4px
            );
            pointer-events: none;
        }

        .stat-card:not(.unlocked)::before {
            content: '🔒';
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            font-size: 0.75rem;
            opacity: 0.3;
            z-index: 2;
        }

        .stat-card:hover {
            background: rgba(0, 0, 0, 0.7);
            transform: translateY(-1px) scale(1.01);
            border-color: rgba(155, 89, 182, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .stat-card.unlocked:hover {
            opacity: 1;
            filter: grayscale(0);
        }

        .stat-avatar {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            background: #1e1830;
            border: 2px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .stat-card:not(.unlocked) .stat-avatar {
            filter: grayscale(1) brightness(0.4);
        }

        .stat-card.unlocked .stat-avatar {
            filter: none;
        }

        .stat-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .stat-info {
            flex: 1;
            min-width: 0;
        }

        .stat-name {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-card:not(.unlocked) .stat-name {
            color: rgba(255, 255, 255, 0.4);
        }

        .stat-card.unlocked .stat-name {
            color: var(--text-primary);
        }

        .stat-role {
            font-size: 0.8rem;
            text-transform: none;
            letter-spacing: normal;
            font-weight: 500;
            line-height: 1.3;
        }

        .stat-card:not(.unlocked) .stat-role {
            color: rgba(255, 255, 255, 0.3);
        }

        .stat-card.unlocked .stat-role {
            color: var(--text-secondary);
        }

        .stat-percentage {
            display: none;
        }

        .agent-card.locked {
            opacity: 0.6;
            filter: grayscale(0.8);
            cursor: not-allowed;
        }

        .agent-card.locked:hover {
            transform: none;
            border-color: var(--border-color);
            box-shadow: none;
        }

        .agent-card.locked::before {
            display: none;
        }

        .agent-card.locked .agent-portrait {
            filter: brightness(0.5) contrast(0.8) grayscale(1);
        }

        .agent-card.locked:hover .agent-portrait {
            transform: none;
            filter: brightness(0.5) contrast(0.8) grayscale(1);
        }

        .agent-locked-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            backdrop-filter: blur(2px);
        }

        .lock-icon {
            font-size: 2.5rem;
            color: rgba(255, 255, 255, 0.5);
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .agent-card.locked .agent-role-badge {
            opacity: 0.3;
        }

        .agent-card.locked .agent-info {
            background: rgba(0, 0, 0, 0.95);
        }

        .agent-card.locked .agent-name,
        .agent-card.locked .agent-subtitle {
            color: rgba(255, 255, 255, 0.4);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .section-title {
                font-size: 1.8rem;
                letter-spacing: 0.1rem;
            }
            
            .header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }
            
            .header-controls {
                flex-direction: column;
                gap: 1rem;
            }
            
            .filter-tabs {
                justify-content: center;
                gap: 0.25rem;
            }
            
            .filter-tab {
                padding: 0.4rem 0.8rem;
                font-size: 0.65rem;
                min-width: 60px;
                text-align: center;
            }
            
            .search-input {
                min-width: auto;
                width: 100%;
                max-width: 100%;
                font-size: 0.85rem;
                padding: 0.6rem 1rem;
            }
            
            .agents-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 1rem;
                padding: 0;
            }
            
            .agent-card {
                aspect-ratio: 2.5/3.5;
                min-height: 220px;
            }
            
            .agent-name {
                font-size: 1rem;
                letter-spacing: 0.1rem;
            }
            
            .agent-subtitle {
                font-size: 0.65rem;
            }
            
            .agent-role-badge {
                font-size: 0.65rem;
                padding: 0.2rem 0.6rem;
                top: 0.75rem;
                right: 0.75rem;
            }
            
            .lock-icon {
                font-size: 2rem;
            }
            
            .agent-meta {
                padding: 1.5rem;
                border-radius: 16px;
            }
            
            .meta-title {
                font-size: 1.4rem;
            }
            
            .meta-description {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            
            .meta-stats {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-avatar {
                width: 40px;
                height: 40px;
            }
            
            .stat-name {
                font-size: 0.9rem;
            }
            
            .stat-role {
                font-size: 0.7rem;
                line-height: 1.2;
            }
            
            .play-button {
                height: 60px;
                padding: 0 1.25rem;
                bottom: 1.5rem;
                right: 1.5rem;
                gap: 0.6rem;
            }
            
            .play-text {
                font-size: 0.85rem;
                letter-spacing: 0.08rem;
            }
            
            .play-icon {
                border-left: 16px solid #ffffff;
                border-top: 10px solid transparent;
                border-bottom: 10px solid transparent;
                margin-left: 3px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0.75rem;
            }
            
            .section-title {
                font-size: 1.6rem;
            }
            
            .agents-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                gap: 0.75rem;
            }
            
            .agent-card {
                aspect-ratio: 2.2/3.2;
                min-height: 200px;
            }
            
            .agent-name {
                font-size: 0.9rem;
            }
            
            .agent-subtitle {
                font-size: 0.6rem;
            }
            
            .agent-role-badge {
                font-size: 0.6rem;
                padding: 0.15rem 0.5rem;
            }
            
            .agent-meta {
                padding: 1.25rem;
            }
            
            .meta-title {
                font-size: 1.2rem;
            }
            
            .meta-description {
                font-size: 0.85rem;
            }
            
            .stat-card {
                padding: 0.75rem;
                gap: 0.75rem;
            }
            
            .stat-avatar {
                width: 36px;
                height: 36px;
            }
            
            .stat-name {
                font-size: 0.85rem;
            }
            
            .stat-role {
                font-size: 0.65rem;
                line-height: 1.2;
            }
            
            .filter-tab {
                padding: 0.35rem 0.6rem;
                font-size: 0.6rem;
            }
            
            .play-button {
                height: 55px;
                padding: 0 1rem;
                bottom: 1.25rem;
                right: 1.25rem;
                gap: 0.5rem;
            }
            
            .play-text {
                font-size: 0.75rem;
                letter-spacing: 0.06rem;
            }
            
            .play-icon {
                border-left: 14px solid #ffffff;
                border-top: 8px solid transparent;
                border-bottom: 8px solid transparent;
                margin-left: 2px;
            }
        }

        @media (max-width: 375px) {
            .agents-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .agent-card {
                min-height: 180px;
            }
            
            .section-title {
                font-size: 1.4rem;
            }
            
            .filter-tabs {
                gap: 0.2rem;
            }
            
            .filter-tab {
                padding: 0.3rem 0.5rem;
                font-size: 0.55rem;
                min-width: 50px;
            }
        }

        @media (min-width: 1200px) {
            .agents-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 2rem;
            }
            
            .agent-meta {
                padding: 2.5rem;
            }
        }

        @media (min-width: 1600px) {
            .agents-section {
                max-width: 1600px;
            }
            
            .agents-grid {
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="particles"></div>
    <div class="agents-section">
        <div class="header">
            <h1 class="section-title">Agents</h1>
            <div class="header-controls">
                <div class="filter-tabs">
                    <div class="filter-tab active" data-role="all">All</div>
                    <div class="filter-tab" data-role="duelist">Duelist</div>
                    <div class="filter-tab" data-role="sentinel">Sentinel</div>
                    <div class="filter-tab" data-role="controller">Controller</div>
                    <div class="filter-tab" data-role="initiator">Initiator</div>
                </div>
                <input type="text" class="search-input" placeholder="Buscar agente...">
            </div>
        </div>

        <div class="agents-grid">
            <!-- Agent cards will be dynamically generated -->
        </div>

        <div class="agent-meta">
            <div class="meta-header">
                <h2 class="meta-title">Selecione um Agente</h2>
            </div>
            <p class="meta-description">
                Clique em um agente para ver suas estatísticas detalhadas e informações de performance.
            </p>
            <div class="meta-stats">
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48?text=💪" alt="Força"></div>
                    <div class="stat-info">
                        <div class="stat-name">Força</div>
                        <div class="stat-role">Ataque</div>
                    </div>
                    <div class="stat-percentage">-</div>
                </div>
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48?text=🛡️" alt="Defesa"></div>
                    <div class="stat-info">
                        <div class="stat-name">Defesa</div>
                        <div class="stat-role">Proteção</div>
                    </div>
                    <div class="stat-percentage">-</div>
                </div>
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48?text=⚡" alt="Agilidade"></div>
                    <div class="stat-info">
                        <div class="stat-name">Agilidade</div>
                        <div class="stat-role">Mobilidade</div>
                    </div>
                    <div class="stat-percentage">-</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botão de Play Flutuante -->
    <div class="play-button" id="playButton">
        <div class="play-icon"></div>
        <span class="play-text">PLAY</span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const agentsGrid = document.querySelector('.agents-grid');
            const metaTitle = document.querySelector('.meta-title');
            const metaDescription = document.querySelector('.meta-description');
            const statCards = document.querySelectorAll('.stat-card');
            const searchInput = document.querySelector('.search-input');

            const agentsData = [
                // AGENTES LIBERADOS (5 total)
                { 
                    name: 'Jett', 
                    role: 'duelist', 
                    unlocked: true,
                    description: 'Ágil e mortal, Jett é uma duelista que domina o campo com velocidade e precisão. Suas habilidades de mobilidade a tornam imprevisível em combate.',
                    stats: { 
                        'Força': 'Alto poder de fogo direto',
                        'Defesa': 'Foca em esquiva rápida',
                        'Agilidade': 'Extremamente móvel'
                    }
                },
                { 
                    name: 'Sage', 
                    role: 'sentinel', 
                    unlocked: true,
                    description: 'Curadora e protetora, Sage mantém o time vivo com suas habilidades de suporte. Uma peça fundamental para qualquer composição.',
                    stats: { 
                        'Força': 'Suporte focado em cura',
                        'Defesa': 'Máxima proteção da equipe',
                        'Agilidade': 'Movimento calculado'
                    }
                },
                { 
                    name: 'Omen', 
                    role: 'controller', 
                    unlocked: true,
                    description: 'Sombroso e misterioso, Omen manipula as sombras para confundir inimigos. Suas fumaças são estratégicas e imprevisíveis.',
                    stats: { 
                        'Força': 'Controle tático do mapa',
                        'Defesa': 'Bloqueios estratégicos',
                        'Agilidade': 'Teleporte instantâneo'
                    }
                },
                { 
                    name: 'Sova', 
                    role: 'initiator', 
                    unlocked: true,
                    description: 'Caçador russo expert, Sova revela inimigos com precisão cirúrgica. Suas flechas de reconhecimento são legendárias.',
                    stats: { 
                        'Força': 'Precisão devastadora',
                        'Defesa': 'Informação como escudo',
                        'Agilidade': 'Movimento tático'
                    }
                },
                { 
                    name: 'Phoenix', 
                    role: 'duelist', 
                    unlocked: true,
                    description: 'Auto-suficiente e confiante, Phoenix pode se curar e ressuscitar com suas chamas. Um duelista versátil para qualquer situação.',
                    stats: { 
                        'Força': 'Fogo devastador',
                        'Defesa': 'Auto-regeneração',
                        'Agilidade': 'Combate equilibrado'
                    }
                },
                
                // AGENTES BLOQUEADOS
                { 
                    name: 'Raze', 
                    role: 'duelist', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Explosivos massivos',
                        'Defesa': 'Agressão como defesa',
                        'Agilidade': 'Mobilidade explosiva'
                    }
                },
                { 
                    name: 'Reyna', 
                    role: 'duelist', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Vampirismo letal',
                        'Defesa': 'Invulnerabilidade temporária',
                        'Agilidade': 'Fuga espectral'
                    }
                },
                { 
                    name: 'Cypher', 
                    role: 'sentinel', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Armadilhas letais',
                        'Defesa': 'Vigilância total',
                        'Agilidade': 'Movimento sigiloso'
                    }
                },
                { 
                    name: 'Killjoy', 
                    role: 'sentinel', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Tecnologia automatizada',
                        'Defesa': 'Gadgets defensivos',
                        'Agilidade': 'Posicionamento estático'
                    }
                },
                { 
                    name: 'Chamber', 
                    role: 'sentinel', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Precisão cirúrgica',
                        'Defesa': 'Teleporte de escape',
                        'Agilidade': 'Mobilidade elegante'
                    }
                },
                { 
                    name: 'Viper', 
                    role: 'controller', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Toxinas corrosivas',
                        'Defesa': 'Barreira química',
                        'Agilidade': 'Controle territorial'
                    }
                },
                { 
                    name: 'Brimstone', 
                    role: 'controller', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Bombardeio orbital',
                        'Defesa': 'Fumaças táticas',
                        'Agilidade': 'Liderança posicional'
                    }
                },
                { 
                    name: 'Astra', 
                    role: 'controller', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Energia cósmica',
                        'Defesa': 'Controle dimensional',
                        'Agilidade': 'Manipulação espacial'
                    }
                },
                { 
                    name: 'Breach', 
                    role: 'initiator', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Sismos devastadores',
                        'Defesa': 'Quebra de defesas',
                        'Agilidade': 'Força bruta'
                    }
                },
                { 
                    name: 'Skye', 
                    role: 'initiator', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Criaturas de combate',
                        'Defesa': 'Cura natural',
                        'Agilidade': 'Conexão selvagem'
                    }
                },
                { 
                    name: 'KAY/O', 
                    role: 'initiator', 
                    unlocked: false,
                    description: 'Agente bloqueado. Complete missões para desbloquear.',
                    stats: { 
                        'Força': 'Supressão tecnológica',
                        'Defesa': 'Blindagem robótica',
                        'Agilidade': 'Eficiência mecânica'
                    }
                }
            ];

            function createAgentCard(agent) {
                const card = document.createElement('div');
                card.className = `agent-card ${agent.unlocked ? '' : 'locked'}`;
                card.dataset.role = agent.role;
                card.dataset.name = agent.name.toLowerCase();
                card.dataset.unlocked = agent.unlocked;
                
                const lockedOverlay = agent.unlocked ? '' : '<div class="agent-locked-overlay"><div class="lock-icon">🔒</div></div>';
                
                card.innerHTML = `
                    <div class="agent-image">
                        <img class="agent-portrait" src="https://via.placeholder.com/300x400/1e1830/9b59b6?text=${encodeURIComponent(agent.name)}" alt="${agent.name}">
                        <div class="agent-role-badge">${agent.role.charAt(0).toUpperCase() + agent.role.slice(1)}</div>
                        ${lockedOverlay}
                    </div>
                    <div class="agent-info">
                        <div class="agent-name">${agent.name}</div>
                        <div class="agent-subtitle">${agent.role.charAt(0).toUpperCase() + agent.role.slice(1)}</div>
                    </div>
                `;

                return card;
            }

            function renderAgents() {
                agentsGrid.innerHTML = '';
                agentsData.forEach(agent => {
                    const card = createAgentCard(agent);
                    agentsGrid.appendChild(card);
                });
                addEventListeners();
            }

            function addEventListeners() {
                const agentCards = document.querySelectorAll('.agent-card');
                
                agentCards.forEach(card => {
                    card.addEventListener('click', () => {
                        // Só permite clique em agentes desbloqueados
                        if (card.dataset.unlocked === 'false') {
                            // Efeito visual para agentes bloqueados
                            card.style.animation = 'shake 0.5s ease-in-out';
                            setTimeout(() => {
                                card.style.animation = '';
                            }, 500);
                            return;
                        }

                        agentCards.forEach(c => c.classList.remove('selected'));
                        card.classList.add('selected');

                        const name = card.querySelector('.agent-name').textContent;
                        const agent = agentsData.find(a => a.name === name);

                        if (agent && agent.unlocked) {
                            metaTitle.textContent = agent.name;
                            metaDescription.textContent = agent.description;

                            statCards.forEach(statCard => {
                                const statName = statCard.querySelector('.stat-name').textContent;
                                const statDescription = agent.stats[statName] || 'Informação não disponível';
                                statCard.querySelector('.stat-role').textContent = statDescription;
                                statCard.classList.add('unlocked');
                            });
                        }
                    });
                });
            }

            function filterAgents(role) {
                const agentCards = document.querySelectorAll('.agent-card');
                
                agentCards.forEach(card => {
                    const cardRole = card.dataset.role;
                    const shouldShow = role === 'all' || cardRole === role;
                    
                    if (shouldShow) {
                        card.style.display = 'block';
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.opacity = '1';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            }

            function searchAgents(query) {
                const agentCards = document.querySelectorAll('.agent-card');
                const searchTerm = query.toLowerCase();
                
                agentCards.forEach(card => {
                    const agentName = card.dataset.name;
                    const shouldShow = agentName.includes(searchTerm);
                    
                    if (shouldShow) {
                        card.style.display = 'block';
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.opacity = '1';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            }

            // Event Listeners
            filterTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    filterTabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    
                    const role = tab.dataset.role;
                    filterAgents(role);
                });
            });

            searchInput.addEventListener('input', (e) => {
                const query = e.target.value;
                if (query.trim() === '') {
                    const activeTab = document.querySelector('.filter-tab.active');
                    filterAgents(activeTab.dataset.role);
                } else {
                    searchAgents(query);
                }
            });

            // Create static particles (no animation)
            const particlesContainer = document.querySelector('.particles');
            const particlesCount = 50;
            
            for (let i = 0; i < particlesCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                particle.style.top = Math.random() * 100 + 'vh';
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.width = particle.style.height = Math.random() * 2 + 1 + 'px';
                particlesContainer.appendChild(particle);
            }

            // Initialize
            renderAgents();
            
            // Play button functionality
            const playButton = document.getElementById('playButton');
            
            playButton.addEventListener('click', () => {
                // Adiciona efeito visual de clique
                playButton.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    playButton.style.transform = '';
                }, 150);
                
                // Simula ação de "jogar" - você pode personalizar esta ação
                const selectedAgent = document.querySelector('.agent-card.selected:not(.locked)');
                if (selectedAgent) {
                    const agentName = selectedAgent.querySelector('.agent-name').textContent;
                    alert(`Iniciando partida com ${agentName}! 🎮`);
                } else {
                    alert('Selecione um agente desbloqueado primeiro! ⚡');
                }
            });
            
            // Auto-select first unlocked agent
            setTimeout(() => {
                const firstUnlockedCard = document.querySelector('.agent-card:not(.locked)');
                if (firstUnlockedCard) {
                    firstUnlockedCard.click();
                }
            }, 100);
        });
    </script>
</body>
</html>