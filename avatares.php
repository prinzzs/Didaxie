    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Valorant - Agents</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

            :root {
                --primary-bg: #0f1419;
                --secondary-bg: #1a1d29;
                --card-bg: #1e2328;
                --accent-color: #5865f2;
                --accent-secondary: #7289da;
                --text-primary: #ffffff;
                --text-secondary: rgba(255, 255, 255, 0.7);
                --border-color: #2a2e33;
                --shadow-glow: rgba(88, 101, 242, 0.3);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                background: radial-gradient(ellipse at top, #1a1d29 0%, #0f1419 70%);
                color: var(--text-primary);
                min-height: 100vh;
                padding: 2rem;
                overflow-x: hidden;
                position: relative;
            }

            /* Animated background particles */
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
                    filter: drop-shadow(0 0 10px rgba(255, 70, 84, 0.5));
                }
                to {
                    filter: drop-shadow(0 0 20px rgba(0, 212, 170, 0.5));
                }
            }

            .filter-tabs {
                display: flex;
                gap: 0.5rem;
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
                background: rgba(88, 101, 242, 0.1);
                border-color: var(--accent-color);
                color: var(--text-primary);
            }

            .filter-tab.active {
                background: var(--accent-color);
                border-color: var(--accent-color);
                color: var(--text-primary);
            }

            .agents-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1.5rem;
                margin-bottom: 3rem;
                padding: 0 0.5rem;
            }

            .agent-card {
                background: linear-gradient(135deg, var(--card-bg) 0%, rgba(30, 35, 40, 0.8) 100%);
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
                    rgba(255, 70, 84, 0.1) 50%, 
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
                background: radial-gradient(circle at center, rgba(255, 70, 84, 0.1) 0%, transparent 70%);
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
                border: 1px solid rgba(0, 212, 170, 0.3);
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

            /* --- ENHANCED AGENT META (seu CSS de baixo) --- */
            .agent-meta {
                background: linear-gradient(135deg, 
                    rgba(255, 70, 84, 0.15) 0%, 
                    rgba(0, 212, 170, 0.15) 100%);
                border: 1px solid rgba(255, 70, 84, 0.2);
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
                    rgba(255, 70, 84, 0.1) 90deg,
                    transparent 180deg,
                    rgba(0, 212, 170, 0.1) 270deg,
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
                opacity: 0.5;
                filter: grayscale(0.7);
            }

            .stat-card::after {
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

            .stat-card::before {
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
                border-color: rgba(88, 101, 242, 0.1);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                opacity: 0.7;
                filter: grayscale(0.5);
            }

            .stat-avatar {
                width: 48px;
                height: 48px;
                border-radius: 8px;
                overflow: hidden;
                flex-shrink: 0;
                background: #1e2328;
                border: 2px solid rgba(255, 255, 255, 0.1);
                position: relative;
                filter: grayscale(1) brightness(0.4);
            }

            .stat-card:hover .stat-avatar {
                filter: grayscale(0.8) brightness(0.6);
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
                color: rgba(255, 255, 255, 0.4);
                margin-bottom: 0.25rem;
            }

            .stat-role {
                font-size: 0.8rem;
                color: rgba(255, 255, 255, 0.3);
                text-transform: uppercase;
                letter-spacing: 0.1rem;
                font-weight: 500;
            }

            .stat-percentage {
                font-size: 1.125rem;
                font-weight: 800;
                color: rgba(255, 255, 255, 0.3);
                background: rgba(0, 0, 0, 0.5);
                padding: 0.5rem 0.875rem;
                border-radius: 8px;
                white-space: nowrap;
                position: relative;
                overflow: hidden;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

        </style>
    </head>
    <body>

    <div class="agents-section">
        <div class="header">
            <h1 class="section-title">Agents</h1>
            <div class="filter-tabs">
                <div class="filter-tab active">All</div>
                <div class="filter-tab">Duelist</div>
                <div class="filter-tab">Sentinel</div>
                <div class="filter-tab">Controller</div>
                <div class="filter-tab">Initiator</div>
            </div>
        </div>

        <div class="agents-grid">
            <!-- Exemplo de agent card -->
            <div class="agent-card">
                <div class="agent-image">
                    <img class="agent-portrait" src="https://via.placeholder.com/300x400" alt="Agent Name">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">Phoenix</div>
                    <div class="agent-subtitle">Duelist</div>
                </div>
            </div>
            <div class="agent-card">
                <div class="agent-image">
                    <img class="agent-portrait" src="https://via.placeholder.com/300x400" alt="Agent Name">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">Phoenix</div>
                    <div class="agent-subtitle">Duelist</div>
                </div>
            </div>
            <div class="agent-card">
                <div class="agent-image">
                    <img class="agent-portrait" src="https://via.placeholder.com/300x400" alt="Agent Name">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">Phoenix</div>
                    <div class="agent-subtitle">Duelist</div>
                </div>
            </div>
            <div class="agent-card">
                <div class="agent-image">
                    <img class="agent-portrait" src="https://via.placeholder.com/300x400" alt="Agent Name">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">Phoenix</div>
                    <div class="agent-subtitle">Duelist</div>
                </div>
            </div>
            <div class="agent-card">
                <div class="agent-image">
                    <img class="agent-portrait" src="https://via.placeholder.com/300x400" alt="Agent Name">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">Phoenix</div>
                    <div class="agent-subtitle">Duelist</div>
                </div>
            </div>
            <div class="agent-card">
                <div class="agent-image">
                    <img class="agent-portrait" src="https://via.placeholder.com/300x400" alt="Agent Name">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">Phoenix</div>
                    <div class="agent-subtitle">Duelist</div>
                </div>
            </div>
            <div class="agent-card">
                <div class="agent-image">
                    <img class="agent-portrait" src="https://via.placeholder.com/300x400" alt="Agent Name">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">Phoenix</div>
                    <div class="agent-subtitle">Duelist</div>
                </div>
            </div>
            <!-- Pode repetir mais cards -->
        </div>

        <div class="agent-meta">
            <div class="meta-header">
                <h2 class="meta-title">Agent Meta</h2>
            </div>
            <p class="meta-description">
                Estatísticas detalhadas de performance do agente em partidas recentes.
            </p>
            <div class="meta-stats">
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48" alt=""></div>
                    <div class="stat-info">
                        <div class="stat-name">KDA</div>
                        <div class="stat-role">Average</div>
                    </div>
                    <div class="stat-percentage">2.5</div>
                </div>
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48" alt=""></div>
                    <div class="stat-info">
                        <div class="stat-name">Win Rate</div>
                        <div class="stat-role">Recent</div>
                    </div>
                    <div class="stat-percentage">53%</div>
                </div>
                <div class="stat-card">
                    <div class="stat-avatar"><img src="https://via.placeholder.com/48" alt=""></div>
                    <div class="stat-info">
                        <div class="stat-name">Headshot %</div>
                        <div class="stat-role">Accuracy</div>
                    </div>
                    <div class="stat-percentage">45%</div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const agentCards = document.querySelectorAll('.agent-card');
    const metaTitle = document.querySelector('.meta-title');
    const metaDescription = document.querySelector('.meta-description');
    const statCards = document.querySelectorAll('.stat-card');

    // Dados atualizados dos agentes
    const agentsData = [
        { name: 'Raze', role: 'Duelist', description: 'Explosiva e criativa, perfeita para iniciar confrontos.', stats: { 'KDA': '2.7', 'Win Rate': '55%', 'Headshot %': '48%' } },
        { name: 'Jett', role: 'Duelist', description: 'Ágil e mortal, domina o campo com velocidade.', stats: { 'KDA': '2.9', 'Win Rate': '57%', 'Headshot %': '50%' } },
        { name: 'Sage', role: 'Sentinel', description: 'Curadora e defensora, protege seu time com maestria.', stats: { 'KDA': '2.1', 'Win Rate': '52%', 'Headshot %': '42%' } },
        { name: 'Cypher', role: 'Sentinel', description: 'Espião e estrategista, controla mapas com suas armadilhas.', stats: { 'KDA': '2.0', 'Win Rate': '50%', 'Headshot %': '40%' } },
        { name: 'Viper', role: 'Controller', description: 'Especialista em controle de mapa com toxinas letais.', stats: { 'KDA': '2.3', 'Win Rate': '49%', 'Headshot %': '44%' } },
        { name: 'Omen', role: 'Controller', description: 'Sombroso e imprevisível, manipula o campo a seu favor.', stats: { 'KDA': '2.2', 'Win Rate': '48%', 'Headshot %': '43%' } },
        { name: 'Sova', role: 'Initiator', description: 'Rastreador preciso, prepara emboscadas e revela inimigos.', stats: { 'KDA': '2.4', 'Win Rate': '51%', 'Headshot %': '46%' } },
        { name: 'Breach', role: 'Initiator', description: 'Força bruta e precisão, abre caminho para seu time.', stats: { 'KDA': '2.3', 'Win Rate': '50%', 'Headshot %': '45%' } }
    ];

    // Atualizar os cards da página com novos dados
    agentCards.forEach((card, index) => {
        const agent = agentsData[index % agentsData.length]; // Cicla caso tenha mais cards que agentes
        card.querySelector('.agent-name').textContent = agent.name;
        card.querySelector('.agent-subtitle').textContent = agent.role;
        card.querySelector('.agent-role-badge').textContent = agent.role;
        card.querySelector('.agent-portrait').src = `https://via.placeholder.com/300x400?text=${encodeURIComponent(agent.name)}`;
        card.querySelector('.agent-portrait').alt = agent.name;
    });

    // Filtrar agentes
    filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            filterTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            const filter = tab.textContent.toLowerCase();

            agentCards.forEach(card => {
                const role = card.querySelector('.agent-role-badge').textContent.toLowerCase();
                if (filter === 'all' || role === filter) {
                    card.style.display = 'block';
                    card.style.opacity = 0;
                    setTimeout(() => card.style.opacity = 1, 50);
                } else {
                    card.style.opacity = 0;
                    setTimeout(() => card.style.display = 'none', 300);
                }
            });
        });
    });

    // Selecionar agente e atualizar stats
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
                });
            }
        });
    });

    // Criar partículas de fundo
    const particlesContainer = document.querySelector('.particles');
    const particlesCount = 80;
    for (let i = 0; i < particlesCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        particle.style.top = Math.random() * 100 + 'vh';
        particle.style.left = Math.random() * 100 + 'vw';
        particle.style.width = particle.style.height = Math.random() * 3 + 1 + 'px';
        particle.style.animationDuration = 4 + Math.random() * 4 + 's';
        particlesContainer.appendChild(particle);
    }

    // Busca por nome
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Buscar agente...';
    searchInput.style.marginLeft = '1rem';
    searchInput.style.padding = '0.3rem 0.6rem';
    searchInput.style.borderRadius = '6px';
    searchInput.style.border = '1px solid rgba(255,255,255,0.2)';
    searchInput.style.background = 'rgba(255,255,255,0.05)';
    searchInput.style.color = 'white';
    searchInput.style.outline = 'none';
    document.querySelector('.header').appendChild(searchInput);

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        agentCards.forEach(card => {
            const name = card.querySelector('.agent-name').textContent.toLowerCase();
            if (name.includes(query)) {
                card.style.display = 'block';
                card.style.opacity = 0;
                setTimeout(() => card.style.opacity = 1, 50);
            } else {
                card.style.opacity = 0;
                setTimeout(() => card.style.display = 'none', 300);
            }
        });
    });

    // Seleciona automaticamente o primeiro agente
    if(agentCards.length > 0) {
        agentCards[0].click();
    }
});
</script>


    </body>
    </html>
