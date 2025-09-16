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

        /* Enhanced Agents Grid */
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

        /* Enhanced Agent Meta */
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
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.1rem;
        }

        .meta-description {
            color: var(--text-secondary);
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
            background: var(--card-bg);
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

        .see-guides-btn {
            background: linear-gradient(45deg, var(--accent-color), var(--accent-secondary));
            color: var(--text-primary);
            border: none;
            padding: 1rem 2rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px var(--shadow-glow);
        }

        .see-guides-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .see-guides-btn:hover::before {
            left: 100%;
        }

        .see-guides-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--shadow-glow);
        }

        .see-guides-btn:active {
            transform: translateY(0px);
        }

        /* Loading animation */
        .loading {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .agents-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1rem;
            }
            
            .meta-stats {
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .filter-tabs {
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            
            .filter-tab {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
            
            .agents-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }
            
            .agent-meta {
                padding: 1.5rem;
            }
        }

        /* Focus states */
        .agent-card:focus,
        .filter-tab:focus,
        .see-guides-btn:focus {
            outline: 2px solid var(--accent-color);
            outline-offset: 4px;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Selection highlight */
        ::selection {
            background: var(--accent-color);
            color: white;
        }
    </style>
</head>
<body>
    <div class="particles"></div>
    
    <div class="agents-section">
        <div class="header">
            <h1 class="section-title loading">Agents</h1>
            <div class="filter-tabs loading" style="animation-delay: 0.2s;">
                <div class="filter-tab active" data-role="all">All</div>
                <div class="filter-tab" data-role="duelist">Duelist</div>
                <div class="filter-tab" data-role="controller">Controller</div>
                <div class="filter-tab" data-role="initiator">Initiator</div>
                <div class="filter-tab" data-role="sentinel">Sentinel</div>
            </div>
        </div>

        <!-- Agents Grid -->
        <div class="agents-grid loading" style="animation-delay: 0.4s;">
            <div class="agent-card" data-agent="jett" data-role="duelist" onclick="selectAgent('jett')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt84c43bc22e5b4019/5eb7cdc1b1f2e27c950d2649/V_AGENTS_587x900_Jett.png" alt="Jett" class="agent-portrait">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">JETT</div>
                    <div class="agent-subtitle">Wind Walker</div>
                </div>
            </div>

            <div class="agent-card" data-agent="raze" data-role="duelist" onclick="selectAgent('raze')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/bltf9bb74bd6bffaca8/5eb7cdc1ae8a4a2e4e6552d6/V_AGENTS_587x900_Raze.png" alt="Raze" class="agent-portrait">
                    <div class="agent-role-badge">Duelist</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">RAZE</div>
                    <div class="agent-subtitle">Explosive Force</div>
                </div>
            </div>

            <div class="agent-card" data-agent="breach" data-role="initiator" onclick="selectAgent('breach')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/bltdbf0e10d0e5c8bb5/5eb7cdc1b5b5b95a8bfcf4f9/V_AGENTS_587x900_Breach.png" alt="Breach" class="agent-portrait">
                    <div class="agent-role-badge">Initiator</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">BREACH</div>
                    <div class="agent-subtitle">Bionic Swede</div>
                </div>
            </div>

            <div class="agent-card selected" data-agent="omen" data-role="controller" onclick="selectAgent('omen')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/bltbadc31b6dce7d69c/5eb7cdc1b1f2e27c950d264f/V_AGENTS_587x900_Omen.png" alt="Omen" class="agent-portrait">
                    <div class="agent-role-badge">Controller</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">OMEN</div>
                    <div class="agent-subtitle">Shadow Hunter</div>
                </div>
            </div>

            <div class="agent-card" data-agent="brimstone" data-role="controller" onclick="selectAgent('brimstone')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt8f5b9d7bf14d1a2a/5eb7cdc1ae8a4a2e4e6552d5/V_AGENTS_587x900_Brimstone.png" alt="Brimstone" class="agent-portrait">
                    <div class="agent-role-badge">Controller</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">BRIMSTONE</div>
                    <div class="agent-subtitle">Veteran Commander</div>
                </div>
            </div>

            <div class="agent-card" data-agent="sage" data-role="sentinel" onclick="selectAgent('sage')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt6f70b37ad1e86fdb/5ecad8ae89091935e5a2b7a2/Sage_portrait.png" alt="Sage" class="agent-portrait">
                    <div class="agent-role-badge">Sentinel</div>
                </div>
                <div class="agent-info">
                    <div class="agent-name">SAGE</div>
                    <div class="agent-subtitle">Radiant Monk</div>
                </div>
            </div>
        </div>

        <!-- Agent Meta -->
        <div class="agent-meta loading" style="animation-delay: 0.6s;">
            <div class="meta-header">
                <h2 class="meta-title">Agent Meta</h2>
                <button class="see-guides-btn">SEE GUIDES</button>
            </div>
            <p class="meta-description">
                Usage is determined by Pick Rate, which is the percentage of games an Agent is picked by any player.
                These statistics are updated regularly based on competitive matches across all ranks.
            </p>
            <div class="meta-stats">
                <div class="stat-card">
                    <div class="stat-avatar">
                        <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt6f70b37ad1e86fdb/5ecad8ae89091935e5a2b7a2/Sage_portrait.png" alt="Sage">
                    </div>
                    <div class="stat-info">
                        <div class="stat-name">Sage</div>
                        <div class="stat-role">Sentinel</div>
                    </div>
                    <div class="stat-percentage">20.1%</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-avatar">
                        <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt1d2bdf9e6a9de146/5ecad95d89091935e5a2b7a7/Raze_portrait.png" alt="Raze">
                    </div>
                    <div class="stat-info">
                        <div class="stat-name">Raze</div>
                        <div class="stat-role">Duelist</div>
                    </div>
                    <div class="stat-percentage">17.8%</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-avatar">
                        <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt5dd20ee85c0d1b80/5ecad96689091935e5a2b7a9/Omen_portrait.png" alt="Omen">
                    </div>
                    <div class="stat-info">
                        <div class="stat-name">Omen</div>
                        <div class="stat-role">Controller</div>
                    </div>
                    <div class="stat-percentage">15.2%</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-avatar">
                        <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/bltaa0fcad3dfd3e01a/5ecad96189091935e5a2b7a8/Phoenix_portrait.png" alt="Phoenix">
                    </div>
                    <div class="stat-info">
                        <div class="stat-name">Phoenix</div>
                        <div class="stat-role">Duelist</div>
                    </div>
                    <div class="stat-percentage">13.5%</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedAgent = 'omen';

        const agents = {
            jett: { name: "JETT", role: "Duelist", subtitle: "Wind Walker" },
            raze: { name: "RAZE", role: "Duelist", subtitle: "Explosive Force" },
            breach: { name: "BREACH", role: "Initiator", subtitle: "Bionic Swede" },
            omen: { name: "OMEN", role: "Controller", subtitle: "Shadow Hunter" },
            brimstone: { name: "BRIMSTONE", role: "Controller", subtitle: "Veteran Commander" },
            sage: { name: "SAGE", role: "Sentinel", subtitle: "Radiant Monk" }
        };

        // Create animated background particles
        function createParticles() {
            const particlesContainer = document.querySelector('.particles');
            const particleCount = 30;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                particle.style.animationDuration = (6 + Math.random() * 4) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        function selectAgent(agentKey) {
            // Haptic feedback for mobile
            if (navigator.vibrate) {
                navigator.vibrate(50);
            }

            // Remove previous selection with animation
            document.querySelectorAll('.agent-card').forEach(card => {
                card.classList.remove('selected');
                card.style.transform = '';
            });

            selectedCard.classList.add('selected');
            selectedAgent = agentKey;

            // Add selection feedback
            selectedCard.style.transform = 'translateY(-8px) scale(1.02)';

            console.log(`Selected agent: ${agents[agentKey].name}`);
        }

        // Filter functionality
        function filterAgents(role) {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const agentCards = document.querySelectorAll('.agent-card');

            // Update active tab
            filterTabs.forEach(tab => tab.classList.remove('active'));
            document.querySelector(`[data-role="${role}"]`).classList.add('active');

            // Filter agents
            agentCards.forEach(card => {
                if (role === 'all' || card.dataset.role === role) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.3s ease forwards';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Event listeners for filter tabs
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                filterAgents(tab.dataset.role);
            });
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.target.classList.contains('agent-card')) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    e.target.click();
                }
            }
        });

        // Touch enhancements
        document.querySelectorAll('.agent-card').forEach(card => {
            card.addEventListener('touchstart', function(e) {
                this.style.transform = 'translateY(-4px) scale(0.98)';
            }, { passive: true });

            card.addEventListener('touchend', function(e) {
                setTimeout(() => {
                    if (this.classList.contains('selected')) {
                        this.style.transform = 'translateY(-8px) scale(1.02)';
                    } else {
                        this.style.transform = 'translateY(0)';
                    }
                }, 100);
            }, { passive: true });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            createParticles();
            
            // Add stagger animation to elements
            const elements = document.querySelectorAll('.loading');
            elements.forEach((el, index) => {
                el.style.animationDelay = (index * 0.2) + 's';
            });
        });