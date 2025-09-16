<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valorant - Agents</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f1419 0%, #1a1d29 50%, #0f1419 100%);
            color: #ffffff;
            min-height: 100vh;
            padding: 2rem;
        }

        .agents-section {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.5rem;
            text-align: left;
        }

        /* Agents Grid */
        .agents-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .agent-card {
            background: #1e2328;
            border: 2px solid #2a2e33;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            aspect-ratio: 4/5;
        }

        .agent-card:hover {
            transform: translateY(-2px);
            border-color: #5865f2;
            box-shadow: 0 8px 25px rgba(88, 101, 242, 0.3);
        }

        .agent-card.selected {
            border-color: #5865f2;
            box-shadow: 0 0 20px rgba(88, 101, 242, 0.6);
            transform: translateY(-2px);
        }

        .agent-card.selected::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(88, 101, 242, 0.15) 0%, transparent 50%);
            z-index: 1;
            pointer-events: none;
        }

        .agent-image {
            height: 85%;
            background: linear-gradient(135deg, #2a2e33 0%, #1e2328 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .agent-portrait {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition: transform 0.3s ease;
        }

        .agent-card:hover .agent-portrait {
            transform: scale(1.05);
        }

        .agent-info {
            height: 15%;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.8);
            position: relative;
            z-index: 2;
        }

        .agent-name {
            font-size: 0.875rem;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            text-align: center;
        }

        /* Agent Meta Section */
        .agent-meta {
            background: linear-gradient(135deg, #5865f2 0%, #4752c4 100%);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .agent-meta::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 100%;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.1) 100%);
            pointer-events: none;
        }

        .meta-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .meta-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
        }

        .meta-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            line-height: 1.4;
            margin-bottom: 1.5rem;
        }

        .meta-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 0.875rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .stat-avatar {
            width: 36px;
            height: 36px;
            border-radius: 4px;
            overflow: hidden;
            flex-shrink: 0;
            background: #2a2e33;
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
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 0.125rem;
        }

        .stat-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.05rem;
        }

        .stat-percentage {
            font-size: 0.875rem;
            font-weight: 700;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            white-space: nowrap;
        }

        .see-guides-btn {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            transition: all 0.2s ease;
            backdrop-filter: blur(10px);
        }

        .see-guides-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .agents-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .meta-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .agents-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }
            
            .meta-stats {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .agents-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Focus states */
        .agent-card:focus {
            outline: 2px solid #5865f2;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="agents-section">
        <h1 class="section-title">Agents</h1>

        <!-- Agents Grid -->
        <div class="agents-grid">
            <div class="agent-card" data-agent="jett" onclick="selectAgent('jett')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt84c43bc22e5b4019/5eb7cdc1b1f2e27c950d2649/V_AGENTS_587x900_Jett.png" alt="Jett" class="agent-portrait">
                </div>
                <div class="agent-info">
                    <div class="agent-name">JETT</div>
                </div>
            </div>

            <div class="agent-card" data-agent="raze" onclick="selectAgent('raze')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/bltf9bb74bd6bffaca8/5eb7cdc1ae8a4a2e4e6552d6/V_AGENTS_587x900_Raze.png" alt="Raze" class="agent-portrait">
                </div>
                <div class="agent-info">
                    <div class="agent-name">RAZE</div>
                </div>
            </div>

            <div class="agent-card" data-agent="breach" onclick="selectAgent('breach')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/bltdbf0e10d0e5c8bb5/5eb7cdc1b5b5b95a8bfcf4f9/V_AGENTS_587x900_Breach.png" alt="Breach" class="agent-portrait">
                </div>
                <div class="agent-info">
                    <div class="agent-name">BREACH</div>
                </div>
            </div>

            <div class="agent-card selected" data-agent="omen" onclick="selectAgent('omen')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/bltbadc31b6dce7d69c/5eb7cdc1b1f2e27c950d264f/V_AGENTS_587x900_Omen.png" alt="Omen" class="agent-portrait">
                </div>
                <div class="agent-info">
                    <div class="agent-name">OMEN</div>
                </div>
            </div>

            <div class="agent-card" data-agent="brimstone" onclick="selectAgent('brimstone')" role="button" tabindex="0">
                <div class="agent-image">
                    <img src="https://images.contentstack.io/v3/assets/bltb6530b271fddd0b1/blt8f5b9d7bf14d1a2a/5eb7cdc1ae8a4a2e4e6552d5/V_AGENTS_587x900_Brimstone.png" alt="Brimstone" class="agent-portrait">
                </div>
                <div class="agent-info">
                    <div class="agent-name">BRIMSTONE</div>
                </div>
            </div>
        </div>

        <!-- Agent Meta -->
        <div class="agent-meta">
            <div class="meta-header">
                <h2 class="meta-title">Agent Meta</h2>
                <button class="see-guides-btn">SEE GUIDES</button>
            </div>
            <p class="meta-description">
                Usage is determined by Pick Rate, which is the percentage of games an Agent is picked by any player.
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
        let selectedAgent = 'omen'; // Omen is pre-selected

        const agents = {
            jett: { name: "JETT", role: "Duelist" },
            raze: { name: "RAZE", role: "Duelist" },
            breach: { name: "BREACH", role: "Initiator" },
            omen: { name: "OMEN", role: "Controller" },
            brimstone: { name: "BRIMSTONE", role: "Controller" }
        };

        function selectAgent(agentKey) {
            // Remove previous selection
            document.querySelectorAll('.agent-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selection to clicked card
            const selectedCard = document.querySelector(`[data-agent="${agentKey}"]`);
            selectedCard.classList.add('selected');

            // Update selected agent
            selectedAgent = agentKey;

            console.log(`Selected agent: ${agents[agentKey].name}`);
        }

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
                this.style.transform = 'translateY(-1px) scale(0.98)';
            }, { passive: true });

            card.addEventListener('touchend', function(e) {
                setTimeout(() => {
                    if (this.classList.contains('selected')) {
                        this.style.transform = 'translateY(-2px)';
                    } else {
                        this.style.transform = 'translateY(0)';
                    }
                }, 100);
            }, { passive: true });
        });
    </script>
</body>
</html>