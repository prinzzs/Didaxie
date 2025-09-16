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
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) translateX(0px);
                opacity: 0.1;
            }
            50% { 
                transform: translateY(-20px) translateX(10px);
                opacity: 0.3;
            }
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
            animation: glow-text 3s ease-in-out infinite alternate;
        }

        @keyframes glow-text {
            from {
                filter: drop-shadow(0 0 10px rgba(155, 89, 182, 0.5));
            }
            to {
                filter: drop-shadow(0 0 20px rgba(142, 68, 173, 0.5));
            }
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
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            border-radius: 18px;
            z-index: -1;
            animation: pulse-border 2s ease-in-out infinite;
        }

        @keyframes pulse-border {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
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
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(
                from 0deg at 50% 50%,
                transparent 0deg,
                rgba(155, 89, 182, 0.1) 90deg,
                transparent 180deg,
                rgba(142, 68, 173, 0.1) 270deg,
                transparent 360deg
            );
            animation: rotate 20s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            font-weight: 500;
        }

        .stat-card:not(.unlocked) .stat-role {
            color: rgba(255, 255, 255, 0.3);
        }

        .stat-card.unlocked .stat-role {
            color: var(--text-secondary);
        }

        .stat-percentage {
            font-size: 1.125rem;
            font-weight: 800;
            background: rgba(0, 0, 0, 0.5);
            padding: 0.5rem 0.875rem;
            border-radius: 8px;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-card:not(.unlocked) .stat-percentage {
            color: rgba(255, 255, 255, 0.3);
        }

        .stat-card.unlocked .stat-percentage {
            color: var(--text-primary);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .header-controls {
                justify-content: center;
            }
            
            .search-input {
                min-width: auto;
                width: 100%;
                max-width: 300px;
            }
            
            .agents-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1rem;
                padding: 0;
            }
            
            .agent-meta {
                padding: 1.5rem;
            }
            
            .meta-stats {
                grid-template-columns: 1fr;
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
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48?text=K" alt="KDA"></div>
                    <div class="stat-info">
                        <div class="stat-name">KDA</div>
                        <div class="stat-role">Average</div>
                    </div>
                    <div class="stat-percentage">-</div>
                </div>
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48?text=W" alt="Win Rate"></div>
                    <div class="stat-info">
                        <div class="stat-name">Win Rate</div>
                        <div class="stat-role">Recent</div>
                    </div>
                    <div class="stat-percentage">-</div>
                </div>
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48?text=H" alt="Headshot"></div>
                    <div class="stat-info">
                        <div class="stat-name">Headshot %</div>
                        <div class="stat-role">Accuracy</div>
                    </div>
                    <div class="stat-percentage">-</div>
                </div>
            </div>
        </div>
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
                { 
                    name: 'Jett', 
                    role: 'duelist', 
                    description: 'Ágil e mortal, Jett é uma duelista que domina o campo com velocidade e precisão. Suas habilidades de mobilidade a tornam imprevisível em combate.',
                    stats: { 'KDA': '2.9', 'Win Rate': '57%', 'Headshot %': '52%' }
                },
                { 
                    name: 'Raze', 
                    role: 'duelist', 
                    description: 'Explosiva e criativa, Raze traz o caos ao campo de batalha com granadas e explosivos. Perfeita para quebrar defesas inimigas.',
                    stats: { 'KDA': '2.7', 'Win Rate': '55%', 'Headshot %': '48%' }
                },
                { 
                    name: 'Phoenix', 
                    role: 'duelist', 
                    description: 'Auto-suficiente e confiante, Phoenix pode se curar e ressuscitar com suas chamas. Um duelista versátil para qualquer situação.',
                    stats: { 'KDA': '2.5', 'Win Rate': '53%', 'Headshot %': '50%' }
                },
                { 
                    name: 'Reyna', 
                    role: 'duelist', 
                    description: 'Vampírica e implacável, Reyna se torna mais forte a cada kill. Uma força da natureza nas mãos certas.',
                    stats: { 'KDA': '3.1', 'Win Rate': '58%', 'Headshot %': '54%' }
                },
                { 
                    name: 'Sage', 
                    role: 'sentinel', 
                    description: 'Curadora e protetora, Sage mantém o time vivo com suas habilidades de suporte. Uma peça fundamental para qualquer composição.',
                    stats: { 'KDA': '2.1', 'Win Rate': '52%', 'Headshot %': '42%' }
                },
                { 
                    name: 'Cypher', 
                    role: 'sentinel', 
                    description: 'Mestre da informação, Cypher controla o mapa com suas câmeras e armadilhas. Nada escapa dos seus olhos eletrônicos.',
                    stats: { 'KDA': '2.0', 'Win Rate': '50%', 'Headshot %': '40%' }
                },
                { 
                    name: 'Killjoy', 
                    role: 'sentinel', 
                    description: 'Gênia da tecnologia, Killjoy defende áreas com seus gadgets automatizados. Suas invenções fazem o trabalho por ela.',
                    stats: { 'KDA': '2.2', 'Win Rate': '51%', 'Headshot %': '43%' }
                },
                { 
                    name: 'Chamber', 
                    role: 'sentinel', 
                    description: 'Francês elegante e preciso, Chamber combina defesa com letalidade. Suas armas customizadas são obras de arte mortais.',
                    stats: { 'KDA': '2.6', 'Win Rate': '54%', 'Headshot %': '58%' }
                },
                { 
                    name: 'Viper', 
                    role: 'controller', 
                    description: 'Especialista em guerra química, Viper controla o mapa com toxinas letais. Suas nuvens tóxicas dividem o campo de batalha.',
                    stats: { 'KDA': '2.3', 'Win Rate': '49%', 'Headshot %': '44%' }
                },
                { 
                    name: 'Omen', 
                    role: 'controller', 
                    description: 'Sombroso e misterioso, Omen manipula as sombras para confundir inimigos. Suas fumaças são estratégicas e imprevisíveis.',
                    stats: { 'KDA': '2.2', 'Win Rate': '48%', 'Headshot %': '43%' }
                },
                { 
                    name: 'Brimstone', 
                    role: 'controller', 
                    description: 'Veterano militar, Brimstone lidera com autoridade e fumaças táticas. Seus orbitais devastam posições inimigas.',
                    stats: { 'KDA': '2.1', 'Win Rate': '47%', 'Headshot %': '41%' }
                },
                { 
                    name: 'Astra', 
                    role: 'controller', 
                    description: 'Controladora cósmica, Astra manipula energias estelares para controlar o campo. Suas estrelas redefinem o mapa.',
                    stats: { 'KDA': '2.4', 'Win Rate': '50%', 'Headshot %': '45%' }
                },
                { 
                    name: 'Sova', 
                    role: 'initiator', 
                    description: 'Caçador russo expert, Sova revela inimigos com precisão cirúrgica. Suas flechas de reconhecimento são legendárias.',
                    stats: { 'KDA': '2.4', 'Win Rate': '51%', 'Headshot %': '46%' }
                },
                { 
                    name: 'Breach', 
                    role: 'initiator', 
                    description: 'Força bruta sueca, Breach quebra defesas com sismos devastadores. Suas habilidades atravessam paredes.',
                    stats: { 'KDA': '2.3', 'Win Rate': '50%', 'Headshot %': '45%' }
                },
                { 
                    name: 'Skye', 
                    role: 'initiator', 
                    description: 'Australiana conectada com a natureza, Skye cura aliados e caça inimigos. Suas criaturas são extensões de sua vontade.',
                    stats: { 'KDA': '2.2', 'Win Rate': '49%', 'Headshot %': '44%' }
                },
                { 
                    name: 'KAY/O', 
                    role: 'initiator', 
                    description: 'Robô anti-radiante, KAY/O suprime habilidades inimigas e oferece suporte tático. Tecnologia contra magia.',
                    stats: { 'KDA': '2.5', 'Win Rate': '52%', 'Headshot %': '47%' }
                }
            ];

            function createAgentCard(agent) {
                const card = document.createElement('div');
                card.className = 'agent-card';
                card.dataset.role = agent.role;
                card.dataset.name = agent.name.toLowerCase();
                
                card.innerHTML = `
                    <div class="agent-image">
                        <img class="agent-portrait" src="https://via.placeholder.com/300x400/1e1830/9b59b6?text=${encodeURIComponent(agent.name)}" alt="${agent.name}">
                        <div class="agent-role-badge">${agent.role.charAt(0).toUpperCase() + agent.role.slice(1)}</div>
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
                        agentCards.forEach(c => c.classList.remove('selected'));
                        card.classList.add('selected');

                        const name = card.querySelector('.agent-name').textContent;
                        const agent = agentsData.find(a => a.name === name);

                        if (agent) {
                            metaTitle.textContent = agent.name;
                            metaDescription.textContent = agent.description;

                            statCards.forEach(statCard => {
                                const statName = statCard.querySelector('.stat-name').textContent;
                                const statValue = agent.stats[statName] || '-';
                                statCard.querySelector('.stat-percentage').textContent = statValue;
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

            // Create particles
            const particlesContainer = document.querySelector('.particles');
            const particlesCount = 80;
            
            for (let i = 0; i < particlesCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                particle.style.top = Math.random() * 100 + 'vh';
                particle.style.left = Math.random() * 100 + 'vw';
                particle.style.width = particle.style.height = Math.random() * 3 + 1 + 'px';
                particle.style.animationDuration = 4 + Math.random() * 4 + 's';
                particle.style.animationDelay = Math.random() * 2 + 's';
                particlesContainer.appendChild(particle);
            }

            // Initialize
            renderAgents();
            
            // Auto-select first agent
            setTimeout(() => {
                const firstCard = document.querySelector('.agent-card');
                if (firstCard) {
                    firstCard.click();
                }
            }, 100);
        });
    </script>
</body>
</html>