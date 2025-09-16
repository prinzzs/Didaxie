<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Quiz - DX Platform</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary-color: #2563eb;
      --primary-dark: #1d4ed8;
      --secondary-color: #64748b;
      --accent-color: #f59e0b;
      --success-color: #10b981;
      --background-color: #f8fafc;
      --card-background: #ffffff;
      --text-primary: #1e293b;
      --text-secondary: #64748b;
      --border-color: #e2e8f0;
      --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
      --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: var(--background-color);
      color: var(--text-primary);
      line-height: 1.6;
    }

    .dashboard {
      display: grid;
      grid-template-columns: 280px 1fr;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      background: linear-gradient(145deg, var(--primary-color), var(--primary-dark));
      padding: 2rem 1.5rem;
      box-shadow: var(--shadow-lg);
      position: relative;
      overflow: hidden;
    }

    .sidebar::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.03"><circle cx="7" cy="7" r="3"/></g></g></svg>');
      pointer-events: none;
    }

    .logo-container {
      position: relative;
      z-index: 2;
      margin-bottom: 3rem;
    }

    .logo {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      color: white;
      width: 60px;
      height: 60px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: -0.02em;
      margin-bottom: 1rem;
      box-shadow: var(--shadow-md);
    }

    .brand-name {
      color: white;
      font-size: 1.25rem;
      font-weight: 600;
      opacity: 0.9;
    }

    .nav-menu {
      position: relative;
      z-index: 2;
      list-style: none;
      margin-bottom: 2rem;
    }

    .nav-item {
      margin-bottom: 0.5rem;
    }

    .nav-link {
      display: flex;
      align-items: center;
      padding: 0.875rem 1rem;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      border-radius: 12px;
      transition: all 0.2s ease;
      font-weight: 500;
    }

    .nav-link:hover,
    .nav-link.active {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      transform: translateX(4px);
    }

    .nav-icon {
      margin-right: 0.75rem;
      font-size: 1.1rem;
    }

    .settings-btn {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: rgba(255, 255, 255, 0.8);
      padding: 0.875rem 1rem;
      border-radius: 12px;
      cursor: pointer;
      width: 100%;
      display: flex;
      align-items: center;
      font-size: 0.875rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .settings-btn:hover {
      background: rgba(255, 255, 255, 0.15);
      color: white;
    }

    /* Main Content */
    .main-content {
      padding: 2rem 3rem;
      overflow-y: auto;
      max-height: 100vh;
    }

    .header {
      margin-bottom: 3rem;
    }

    .welcome-section {
      background: linear-gradient(135deg, var(--card-background), #f1f5f9);
      padding: 2rem;
      border-radius: 20px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      margin-bottom: 2rem;
    }

    .welcome-title {
      font-size: 2rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .welcome-subtitle {
      color: var(--text-secondary);
      font-size: 1.1rem;
      font-weight: 400;
    }

    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.5rem;
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text-primary);
      display: flex;
      align-items: center;
    }

    .section-title::before {
      content: '';
      width: 4px;
      height: 24px;
      background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
      border-radius: 2px;
      margin-right: 1rem;
    }

    .view-all-btn {
      background: none;
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      padding: 0.5rem 1.25rem;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.2s ease;
      text-decoration: none;
      font-size: 0.875rem;
    }

    .view-all-btn:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-1px);
    }

    /* Quiz Cards */
    .featured-quizzes {
      margin-bottom: 3rem;
    }

    .quiz-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .quiz-card {
      background: var(--card-background);
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--border-color);
      transition: all 0.3s ease;
      cursor: pointer;
      position: relative;
    }

    .quiz-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
      border-color: var(--primary-color);
    }

    .quiz-image {
      height: 180px;
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      position: relative;
      overflow: hidden;
    }

    .quiz-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><g fill="rgba(255,255,255,0.1)"><path d="M20 10L30 25H10z"/></g></svg>');
      background-size: 80px 80px;
    }

    .quiz-badge {
      position: absolute;
      top: 1rem;
      right: 1rem;
      background: rgba(255, 255, 255, 0.9);
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--primary-color);
    }

    .quiz-content {
      padding: 1.5rem;
    }

    .quiz-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
      line-height: 1.4;
    }

    .quiz-description {
      color: var(--text-secondary);
      margin-bottom: 1rem;
      font-size: 0.875rem;
      line-height: 1.5;
    }

    .quiz-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 1rem;
      border-top: 1px solid var(--border-color);
    }

    .quiz-stats {
      display: flex;
      gap: 1rem;
      font-size: 0.75rem;
      color: var(--text-secondary);
    }

    .stat-item {
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }

    .play-btn {
      background: var(--primary-color);
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      font-size: 0.875rem;
      transition: all 0.2s ease;
    }

    .play-btn:hover {
      background: var(--primary-dark);
      transform: scale(1.05);
    }

    /* My Quizzes Section */
    .my-quizzes-section {
      margin-bottom: 2rem;
    }

    .quiz-thumbnails {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
    }

    .quiz-thumbnail {
      background: var(--card-background);
      border: 2px dashed var(--border-color);
      border-radius: 12px;
      height: 120px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
      overflow: hidden;
    }

    .quiz-thumbnail:hover {
      border-color: var(--primary-color);
      transform: scale(1.02);
    }

    .quiz-thumbnail.filled {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
      border: none;
      color: white;
      font-weight: 600;
    }

    .add-quiz-btn {
      background: none;
      border: none;
      color: var(--text-secondary);
      font-size: 2rem;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .quiz-thumbnail:hover .add-quiz-btn {
      color: var(--primary-color);
      transform: scale(1.1);
    }

    .create-quiz-card {
      background: linear-gradient(135deg, var(--success-color), #059669);
      color: white;
      border: none;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      font-weight: 600;
    }

    .create-quiz-card:hover {
      transform: scale(1.05);
      box-shadow: var(--shadow-md);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .dashboard {
        grid-template-columns: 1fr;
      }

      .sidebar {
        display: none;
      }

      .main-content {
        padding: 1rem;
      }

      .quiz-grid {
        grid-template-columns: 1fr;
      }

      .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="logo-container">
        <div class="logo">DX</div>
        <div class="brand-name">Quiz Platform</div>
      </div>
      
      <nav>
        <ul class="nav-menu">
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <span class="nav-icon">🏠</span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="nav-icon">📊</span>
              Meus Quizes
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="nav-icon">📈</span>
              Resultados
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="nav-icon">👥</span>
              Turmas
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="nav-icon">📚</span>
              Biblioteca
            </a>
          </li>
        </ul>
      </nav>

      <button class="settings-btn">
        <span class="nav-icon">⚙️</span>
        Configurações
      </button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Header -->
      <header class="header">
        <div class="welcome-section">
          <h1 class="welcome-title">Bem-vindo de volta!</h1>
          <p class="welcome-subtitle">Pronto para criar quizes incríveis e engajar seus alunos?</p>
        </div>
      </header>

      <!-- Featured Quizzes -->
      <section class="featured-quizzes">
        <div class="section-header">
          <h2 class="section-title">Quizes em Destaque</h2>
          <a href="#" class="view-all-btn">Ver Todos</a>
        </div>
        
        <div class="quiz-grid">
          <div class="quiz-card">
            <div class="quiz-image">
              <div class="quiz-badge">Novo</div>
            </div>
            <div class="quiz-content">
              <h3 class="quiz-title">História do Brasil</h3>
              <p class="quiz-description">Teste seus conhecimentos sobre os principais eventos da história brasileira desde o descobrimento.</p>
              <div class="quiz-meta">
                <div class="quiz-stats">
                  <span class="stat-item">⏱️ 15 min</span>
                  <span class="stat-item">❓ 20 questões</span>
                  <span class="stat-item">⭐ 4.8</span>
                </div>
                <button class="play-btn">Iniciar</button>
              </div>
            </div>
          </div>

          <div class="quiz-card">
            <div class="quiz-image">
              <div class="quiz-badge">Popular</div>
            </div>
            <div class="quiz-content">
              <h3 class="quiz-title">Matemática Básica</h3>
              <p class="quiz-description">Fundamentos de matemática para ensino médio incluindo álgebra, geometria e estatística básica.</p>
              <div class="quiz-meta">
                <div class="quiz-stats">
                  <span class="stat-item">⏱️ 25 min</span>
                  <span class="stat-item">❓ 30 questões</span>
                  <span class="stat-item">⭐ 4.6</span>
                </div>
                <button class="play-btn">Iniciar</button>
              </div>
            </div>
          </div>

          <div class="quiz-card">
            <div class="quiz-image">
              <div class="quiz-badge">Trending</div>
            </div>
            <div class="quiz-content">
              <h3 class="quiz-title">Ciências Naturais</h3>
              <p class="quiz-description">Explore conceitos de biologia, química e física de forma interativa e divertida.</p>
              <div class="quiz-meta">
                <div class="quiz-stats">
                  <span class="stat-item">⏱️ 20 min</span>
                  <span class="stat-item">❓ 25 questões</span>
                  <span class="stat-item">⭐ 4.9</span>
                </div>
                <button class="play-btn">Iniciar</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- My Quizzes -->
      <section class="my-quizzes-section">
        <div class="section-header">
          <h2 class="section-title">Seus Quizes</h2>
          <a href="#" class="view-all-btn">Gerenciar</a>
        </div>
        
        <div class="quiz-thumbnails">
          <div class="quiz-thumbnail create-quiz-card">
            <span style="font-size: 2rem;">➕</span>
            <span>Criar Novo Quiz</span>
          </div>
          
          <div class="quiz-thumbnail filled">
            <span>Quiz de Geografia</span>
          </div>
          
          <div class="quiz-thumbnail filled">
            <span>Inglês Básico</span>
          </div>
          
          <div class="quiz-thumbnail">
            <button class="add-quiz-btn">+</button>
          </div>
          
          <div class="quiz-thumbnail">
            <button class="add-quiz-btn">+</button>
          </div>
        </div>
      </section>
    </main>
  </div>

  <script>
    // Sistema de dados simulado
    class QuizData {
      constructor() {
        this.quizzes = [
          {
            id: 1,
            title: 'História do Brasil',
            description: 'Teste seus conhecimentos sobre os principais eventos da história brasileira desde o descobrimento.',
            duration: 15,
            questions: 20,
            rating: 4.8,
            badge: 'Novo',
            category: 'História',
            difficulty: 'Médio',
            attempts: 1247,
            successRate: 78
          },
          {
            id: 2,
            title: 'Matemática Básica',
            description: 'Fundamentos de matemática para ensino médio incluindo álgebra, geometria e estatística básica.',
            duration: 25,
            questions: 30,
            rating: 4.6,
            badge: 'Popular',
            category: 'Matemática',
            difficulty: 'Fácil',
            attempts: 2341,
            successRate: 85
          },
          {
            id: 3,
            title: 'Ciências Naturais',
            description: 'Explore conceitos de biologia, química e física de forma interativa e divertida.',
            duration: 20,
            questions: 25,
            rating: 4.9,
            badge: 'Trending',
            category: 'Ciências',
            difficulty: 'Difícil',
            attempts: 892,
            successRate: 72
          }
        ];

        this.userQuizzes = [
          { id: 101, title: 'Quiz de Geografia', status: 'published', plays: 45 },
          { id: 102, title: 'Inglês Básico', status: 'draft', plays: 0 }
        ];

        this.userStats = {
          totalQuizzes: 2,
          totalPlays: 45,
          avgRating: 4.3,
          totalStudents: 128
        };
      }
    }

    // Sistema de notificações
    class NotificationSystem {
      constructor() {
        this.container = this.createNotificationContainer();
        document.body.appendChild(this.container);
      }

      createNotificationContainer() {
        const container = document.createElement('div');
        container.style.cssText = `
          position: fixed;
          top: 20px;
          right: 20px;
          z-index: 10000;
          pointer-events: none;
        `;
        return container;
      }

      show(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        const colors = {
          success: '#10b981',
          error: '#ef4444',
          warning: '#f59e0b',
          info: '#2563eb'
        };

        notification.style.cssText = `
          background: ${colors[type]};
          color: white;
          padding: 1rem 1.5rem;
          border-radius: 12px;
          margin-bottom: 0.5rem;
          transform: translateX(100%);
          transition: all 0.3s ease;
          pointer-events: auto;
          box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
          font-weight: 500;
          max-width: 300px;
        `;
        
        notification.textContent = message;
        this.container.appendChild(notification);

        // Animação de entrada
        setTimeout(() => {
          notification.style.transform = 'translateX(0)';
        }, 10);

        // Remoção automática
        setTimeout(() => {
          notification.style.transform = 'translateX(100%)';
          setTimeout(() => {
            if (notification.parentNode) {
              notification.parentNode.removeChild(notification);
            }
          }, 300);
        }, duration);
      }
    }

    // Sistema de modal
    class ModalSystem {
      constructor() {
        this.activeModal = null;
      }

      show(content, options = {}) {
        this.hide();
        
        const overlay = document.createElement('div');
        overlay.className = 'modal-overlay';
        overlay.style.cssText = `
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: rgba(0, 0, 0, 0.5);
          backdrop-filter: blur(4px);
          z-index: 9999;
          display: flex;
          align-items: center;
          justify-content: center;
          opacity: 0;
          transition: opacity 0.3s ease;
        `;

        const modal = document.createElement('div');
        modal.style.cssText = `
          background: white;
          border-radius: 16px;
          padding: 2rem;
          max-width: 500px;
          max-height: 80vh;
          overflow-y: auto;
          transform: scale(0.9);
          transition: transform 0.3s ease;
          box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        `;

        modal.innerHTML = content;
        overlay.appendChild(modal);
        document.body.appendChild(overlay);

        // Animação
        setTimeout(() => {
          overlay.style.opacity = '1';
          modal.style.transform = 'scale(1)';
        }, 10);

        // Fechar ao clicar fora
        overlay.addEventListener('click', (e) => {
          if (e.target === overlay) {
            this.hide();
          }
        });

        this.activeModal = overlay;
        return modal;
      }

      hide() {
        if (this.activeModal) {
          this.activeModal.style.opacity = '0';
          this.activeModal.querySelector('div').style.transform = 'scale(0.9)';
          setTimeout(() => {
            if (this.activeModal && this.activeModal.parentNode) {
              this.activeModal.parentNode.removeChild(this.activeModal);
            }
            this.activeModal = null;
          }, 300);
        }
      }
    }

    // Sistema de busca e filtros
    class SearchSystem {
      constructor(quizData) {
        this.data = quizData;
        this.filters = {
          category: 'all',
          difficulty: 'all',
          rating: 0
        };
      }

      search(query) {
        const results = this.data.quizzes.filter(quiz => 
          quiz.title.toLowerCase().includes(query.toLowerCase()) ||
          quiz.description.toLowerCase().includes(query.toLowerCase()) ||
          quiz.category.toLowerCase().includes(query.toLowerCase())
        );
        return this.applyFilters(results);
      }

      applyFilters(quizzes) {
        return quizzes.filter(quiz => {
          if (this.filters.category !== 'all' && quiz.category !== this.filters.category) return false;
          if (this.filters.difficulty !== 'all' && quiz.difficulty !== this.filters.difficulty) return false;
          if (quiz.rating < this.filters.rating) return false;
          return true;
        });
      }

      setFilter(type, value) {
        this.filters[type] = value;
      }
    }

    // Sistema de analytics simulado
    class AnalyticsSystem {
      constructor() {
        this.data = {
          dailyViews: this.generateDailyData(30),
          quizPerformance: [],
          userEngagement: {
            totalUsers: 1247,
            activeUsers: 892,
            newUsers: 156,
            returnRate: 73.2
          }
        };
      }

      generateDailyData(days) {
        const data = [];
        for (let i = days; i >= 0; i--) {
          data.push({
            date: new Date(Date.now() - i * 24 * 60 * 60 * 1000),
            views: Math.floor(Math.random() * 200) + 50,
            completions: Math.floor(Math.random() * 150) + 30
          });
        }
        return data;
      }

      getWeeklyStats() {
        const weekData = this.data.dailyViews.slice(-7);
        const totalViews = weekData.reduce((sum, day) => sum + day.views, 0);
        const totalCompletions = weekData.reduce((sum, day) => sum + day.completions, 0);
        
        return {
          views: totalViews,
          completions: totalCompletions,
          completionRate: ((totalCompletions / totalViews) * 100).toFixed(1)
        };
      }
    }

    // Inicialização do sistema
    const quizData = new QuizData();
    const notifications = new NotificationSystem();
    const modal = new ModalSystem();
    const search = new SearchSystem(quizData);
    const analytics = new AnalyticsSystem();

    // Função para mostrar detalhes do quiz
    function showQuizDetails(quizId) {
      const quiz = quizData.quizzes.find(q => q.id === quizId);
      if (!quiz) return;

      const content = `
        <div style="text-align: center;">
          <h2 style="margin-bottom: 1rem; color: #1e293b;">${quiz.title}</h2>
          <div style="display: inline-block; background: #2563eb; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; margin-bottom: 1rem;">
            ${quiz.badge}
          </div>
          <p style="color: #64748b; margin-bottom: 1.5rem; line-height: 1.6;">${quiz.description}</p>
          
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem; text-align: left;">
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <strong style="color: #1e293b;">Duração:</strong> ${quiz.duration} minutos
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <strong style="color: #1e293b;">Questões:</strong> ${quiz.questions}
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <strong style="color: #1e293b;">Dificuldade:</strong> ${quiz.difficulty}
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <strong style="color: #1e293b;">Avaliação:</strong> ⭐ ${quiz.rating}
            </div>
          </div>

          <div style="background: #eff6ff; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: left;">
            <h4 style="margin-bottom: 0.5rem; color: #1e293b;">📊 Estatísticas</h4>
            <p style="margin: 0.25rem 0; color: #64748b;"><strong>${quiz.attempts.toLocaleString()}</strong> tentativas realizadas</p>
            <p style="margin: 0.25rem 0; color: #64748b;"><strong>${quiz.successRate}%</strong> taxa de sucesso</p>
          </div>

          <div style="display: flex; gap: 1rem; justify-content: center;">
            <button onclick="startQuiz(${quiz.id})" style="background: #2563eb; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600;">
              🚀 Iniciar Quiz
            </button>
            <button onclick="previewQuiz(${quiz.id})" style="background: #64748b; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600;">
              👁️ Visualizar
            </button>
          </div>
        </div>
      `;

      modal.show(content);
    }

    // Função para iniciar quiz
    function startQuiz(quizId) {
      modal.hide();
      notifications.show('Preparando quiz...', 'info', 1000);
      
      setTimeout(() => {
        notifications.show('Quiz iniciado com sucesso!', 'success');
        // Aqui seria redirecionado para a página do quiz
        console.log(`Iniciando quiz ${quizId}`);
      }, 1000);
    }

    // Função para preview do quiz
    function previewQuiz(quizId) {
      modal.hide();
      notifications.show('Carregando preview...', 'info');
      
      setTimeout(() => {
        const content = `
          <div>
            <h3 style="margin-bottom: 1rem; color: #1e293b;">📝 Preview das Questões</h3>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
              <p style="font-weight: 600; margin-bottom: 0.5rem;">Questão 1:</p>
              <p style="color: #64748b; margin-bottom: 0.5rem;">Em que ano foi proclamada a Independência do Brasil?</p>
              <div style="font-size: 0.875rem; color: #64748b;">
                A) 1820 | B) 1822 | C) 1824 | D) 1825
              </div>
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
              <p style="font-weight: 600; margin-bottom: 0.5rem;">Questão 2:</p>
              <p style="color: #64748b; margin-bottom: 0.5rem;">Quem foi o primeiro presidente do Brasil?</p>
              <div style="font-size: 0.875rem; color: #64748b;">
                A) Getúlio Vargas | B) Deodoro da Fonseca | C) Floriano Peixoto | D) Dom Pedro II
              </div>
            </div>
            <p style="text-align: center; color: #64748b; font-style: italic;">... e mais 18 questões</p>
            <button onclick="modal.hide()" style="background: #2563eb; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; cursor: pointer; width: 100%; margin-top: 1rem;">
              Fechar Preview
            </button>
          </div>
        `;
        modal.show(content);
      }, 500);
    }

    // Sistema de dashboard stats em tempo real
    function updateDashboardStats() {
      const weeklyStats = analytics.getWeeklyStats();
      const statsHTML = `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1rem 0;">
          <div style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 1.5rem; border-radius: 12px;">
            <h4 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; opacity: 0.9;">VISUALIZAÇÕES (7 dias)</h4>
            <p style="margin: 0; font-size: 1.75rem; font-weight: 700;">${weeklyStats.views.toLocaleString()}</p>
          </div>
          <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1.5rem; border-radius: 12px;">
            <h4 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; opacity: 0.9;">CONCLUSÕES</h4>
            <p style="margin: 0; font-size: 1.75rem; font-weight: 700;">${weeklyStats.completions.toLocaleString()}</p>
          </div>
          <div style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 1.5rem; border-radius: 12px;">
            <h4 style="margin: 0 0 0.5rem 0; font-size: 0.875rem; opacity: 0.9;">TAXA DE CONCLUSÃO</h4>
            <p style="margin: 0; font-size: 1.75rem; font-weight: 700;">${weeklyStats.completionRate}%</p>
          </div>
        </div>
      `;
      
      // Encontrar lugar para inserir stats
      const welcomeSection = document.querySelector('.welcome-section');
      if (welcomeSection && !document.querySelector('.dashboard-stats')) {
        const statsDiv = document.createElement('div');
        statsDiv.className = 'dashboard-stats';
        statsDiv.innerHTML = statsHTML;
        welcomeSection.appendChild(statsDiv);
      }
    }

    // Funcionalidade de pesquisa
    function createSearchBar() {
      const searchHTML = `
        <div style="position: relative; margin-bottom: 1rem;">
          <input type="text" id="quiz-search" placeholder="🔍 Pesquisar quizes..." 
                 style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 1rem; transition: all 0.2s;">
          <div id="search-results" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border-radius: 8px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); display: none; z-index: 1000; max-height: 300px; overflow-y: auto;"></div>
        </div>
      `;
      
      const featuredSection = document.querySelector('.featured-quizzes');
      if (featuredSection) {
        const searchDiv = document.createElement('div');
        searchDiv.innerHTML = searchHTML;
        featuredSection.insertBefore(searchDiv, featuredSection.querySelector('.quiz-grid'));
      }

      // Funcionalidade de busca
      const searchInput = document.getElementById('quiz-search');
      const resultsDiv = document.getElementById('search-results');
      
      if (searchInput) {
        searchInput.addEventListener('focus', () => {
          searchInput.style.borderColor = '#2563eb';
        });

        searchInput.addEventListener('blur', () => {
          searchInput.style.borderColor = '#e2e8f0';
          setTimeout(() => resultsDiv.style.display = 'none', 200);
        });

        searchInput.addEventListener('input', (e) => {
          const query = e.target.value.trim();
          if (query.length > 0) {
            const results = search.search(query);
            displaySearchResults(results, resultsDiv);
          } else {
            resultsDiv.style.display = 'none';
          }
        });
      }
    }

    function displaySearchResults(results, container) {
      if (results.length === 0) {
        container.innerHTML = '<div style="padding: 1rem; text-align: center; color: #64748b;">Nenhum quiz encontrado</div>';
      } else {
        container.innerHTML = results.map(quiz => `
          <div onclick="showQuizDetails(${quiz.id})" style="padding: 1rem; border-bottom: 1px solid #f1f5f9; cursor: pointer; transition: background 0.2s;" 
               onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
            <div style="font-weight: 600; color: #1e293b; margin-bottom: 0.25rem;">${quiz.title}</div>
            <div style="font-size: 0.875rem; color: #64748b;">${quiz.category} • ${quiz.difficulty} • ⭐ ${quiz.rating}</div>
          </div>
        `).join('');
      }
      container.style.display = 'block';
    }

    // Sistema de arrastar e soltar para reordenar quizes
    function initializeDragAndDrop() {
      const thumbnails = document.querySelectorAll('.quiz-thumbnail.filled');
      
      thumbnails.forEach(thumb => {
        thumb.draggable = true;
        thumb.style.cursor = 'grab';
        
        thumb.addEventListener('dragstart', (e) => {
          thumb.style.opacity = '0.5';
          thumb.style.cursor = 'grabbing';
          e.dataTransfer.setData('text/plain', thumb.textContent);
        });
        
        thumb.addEventListener('dragend', () => {
          thumb.style.opacity = '1';
          thumb.style.cursor = 'grab';
        });
        
        thumb.addEventListener('dragover', (e) => {
          e.preventDefault();
          thumb.style.borderColor = '#2563eb';
        });
        
        thumb.addEventListener('dragleave', () => {
          thumb.style.borderColor = '';
        });
        
        thumb.addEventListener('drop', (e) => {
          e.preventDefault();
          const draggedText = e.dataTransfer.getData('text/plain');
          const currentText = thumb.textContent;
          
          // Trocar conteúdos
          const draggedElement = Array.from(thumbnails).find(t => t.textContent === draggedText);
          if (draggedElement) {
            thumb.textContent = draggedText;
            draggedElement.textContent = currentText;
            notifications.show('Quizes reordenados!', 'success');
          }
          
          thumb.style.borderColor = '';
        });
      });
    }

    // Inicialização completa
    document.addEventListener('DOMContentLoaded', () => {
      // Navegação
      document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', (e) => {
          e.preventDefault();
          document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
          link.classList.add('active');
          notifications.show(`Navegando para: ${link.textContent.trim()}`, 'info', 2000);
        });
      });

      // Cards de quiz com detalhes
      document.querySelectorAll('.quiz-card').forEach((card, index) => {
        card.addEventListener('click', () => {
          showQuizDetails(index + 1);
        });
      });

      // Botões de play
      document.querySelectorAll('.play-btn').forEach((btn, index) => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          startQuiz(index + 1);
        });
      });

      // Criar novo quiz
      document.querySelector('.create-quiz-card')?.addEventListener('click', () => {
        const content = `
          <div>
            <h3 style="margin-bottom: 1.5rem; color: #1e293b; text-align: center;">🎯 Criar Novo Quiz</h3>
            <div style="margin-bottom: 1rem;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Título do Quiz</label>
              <input type="text" placeholder="Ex: História do Brasil" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;">
            </div>
            <div style="margin-bottom: 1rem;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Categoria</label>
              <select style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px;">
                <option>História</option>
                <option>Matemática</option>
                <option>Ciências</option>
                <option>Geografia</option>
                <option>Português</option>
              </select>
            </div>
            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Descrição</label>
              <textarea placeholder="Descreva o conteúdo do seu quiz..." style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; resize: vertical; min-height: 80px;"></textarea>
            </div>
            <div style="display: flex; gap: 1rem;">
              <button onclick="modal.hide()" style="flex: 1; background: #6b7280; color: white; border: none; padding: 0.75rem; border-radius: 8px; cursor: pointer;">
                Cancelar
              </button>
              <button onclick="createNewQuiz()" style="flex: 1; background: #10b981; color: white; border: none; padding: 0.75rem; border-radius: 8px; cursor: pointer; font-weight: 600;">
                🚀 Criar Quiz
              </button>
            </div>
          </div>
        `;
        modal.show(content);
      });

      // Configurações
      document.querySelector('.settings-btn')?.addEventListener('click', () => {
        const content = `
          <div>
            <h3 style="margin-bottom: 1.5rem; color: #1e293b; text-align: center;">⚙️ Configurações</h3>
            <div style="margin-bottom: 1rem;">
              <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" checked style="margin-right: 0.5rem;">
                <span>Notificações por email</span>
              </label>
            </div>
            <div style="margin-bottom: 1rem;">
              <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" style="margin-right: 0.5rem;">
                <span>Modo escuro</span>
              </label>
            </div>
            <div style="margin-bottom: 1.5rem;">
              <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Idioma</label>
              <select style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 6px;">
                <option>Português (BR)</option>
                <option>English</option>
                <option>Español</option>
              </select>
            </div>
            <button onclick="modal.hide(); notifications.show('Configurações salvas!', 'success')" 
                    style="width: 100%; background: #2563eb; color: white; border: none; padding: 0.75rem; border-radius: 8px; cursor: pointer; font-weight: 600;">
              Salvar Configurações
            </button>
          </div>
        `;
        modal.show(content);
      });

      // Inicializar funcionalidades avançadas
      setTimeout(() => {
        updateDashboardStats();
        createSearchBar();
        initializeDragAndDrop();
        
        // Animação de entrada suave
        const cards = document.querySelectorAll('.quiz-card, .quiz-thumbnail');
        cards.forEach((card, index) => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, index * 100);
        });

        // Mensagem de boas-vindas
        setTimeout(() => {
          notifications.show('Dashboard carregado com sucesso! 🎉', 'success');
        }, 1000);

        // Atualizar stats periodicamente
        setInterval(updateDashboardStats, 30000);
      }, 500);
    });

    // Função para criar novo quiz
    function createNewQuiz() {
      modal.hide();
      notifications.show('Criando novo quiz...', 'info');
      
      setTimeout(() => {
        notifications.show('Quiz criado com sucesso!', 'success');
        // Aqui adicionaria o novo quiz à interface
      }, 2000);
    }

    // Função para exportar dados
    function exportData() {
      const data = {
        quizzes: quizData.quizzes,
        userQuizzes: quizData.userQuizzes,
        stats: analytics.getWeeklyStats(),
        timestamp: new Date().toISOString()
      };
      
      const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `quiz-dashboard-export-${new Date().toISOString().split('T')[0]}.json`;
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      URL.revokeObjectURL(url);
      notifications.show('Dados exportados com sucesso!', 'success');
    }

    // Sistema de temas
    class ThemeSystem {
      constructor() {
        this.currentTheme = localStorage.getItem('quiz-theme') || 'light';
        this.init();
      }

      init() {
        if (this.currentTheme === 'dark') {
          this.applyDarkTheme();
        }
      }

      toggle() {
        this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('quiz-theme', this.currentTheme);
        
        if (this.currentTheme === 'dark') {
          this.applyDarkTheme();
        } else {
          this.applyLightTheme();
        }
        
        notifications.show(`Tema ${this.currentTheme === 'dark' ? 'escuro' : 'claro'} aplicado!`, 'info');
      }

      applyDarkTheme() {
        document.documentElement.style.setProperty('--background-color', '#0f172a');
        document.documentElement.style.setProperty('--card-background', '#1e293b');
        document.documentElement.style.setProperty('--text-primary', '#f1f5f9');
        document.documentElement.style.setProperty('--text-secondary', '#94a3b8');
        document.documentElement.style.setProperty('--border-color', '#334155');
      }

      applyLightTheme() {
        document.documentElement.style.setProperty('--background-color', '#f8fafc');
        document.documentElement.style.setProperty('--card-background', '#ffffff');
        document.documentElement.style.setProperty('--text-primary', '#1e293b');
        document.documentElement.style.setProperty('--text-secondary', '#64748b');
        document.documentElement.style.setProperty('--border-color', '#e2e8f0');
      }
    }

    // Sistema de progresso de quiz
    class QuizProgress {
      constructor() {
        this.currentQuiz = null;
        this.currentQuestion = 0;
        this.answers = [];
        this.startTime = null;
      }

      startQuiz(quizId) {
        this.currentQuiz = quizData.quizzes.find(q => q.id === quizId);
        this.currentQuestion = 0;
        this.answers = [];
        this.startTime = Date.now();
        
        this.showQuestionInterface();
      }

      showQuestionInterface() {
        const questions = this.generateQuestions();
        const currentQ = questions[this.currentQuestion];
        
        const content = `
          <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
              <h3 style="color: #1e293b; margin: 0;">${this.currentQuiz.title}</h3>
              <span style="background: #e5e7eb; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem;">
                ${this.currentQuestion + 1}/${questions.length}
              </span>
            </div>
            
            <div style="background: #f3f4f6; height: 8px; border-radius: 4px; margin-bottom: 1.5rem; overflow: hidden;">
              <div style="background: linear-gradient(90deg, #2563eb, #1d4ed8); height: 100%; width: ${((this.currentQuestion + 1) / questions.length) * 100}%; transition: width 0.3s ease;"></div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h4 style="color: #1e293b; margin-bottom: 1rem; font-size: 1.1rem;">${currentQ.question}</h4>
              <div style="display: grid; gap: 0.75rem;">
                ${currentQ.options.map((option, index) => `
                  <button onclick="selectAnswer(${index})" class="quiz-option" data-index="${index}"
                          style="text-align: left; padding: 1rem; border: 2px solid #e5e7eb; border-radius: 8px; background: white; cursor: pointer; transition: all 0.2s;">
                    ${String.fromCharCode(65 + index)}) ${option}
                  </button>
                `).join('')}
              </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center;">
              <div style="color: #6b7280; font-size: 0.875rem;">
                ⏱️ Tempo: <span id="quiz-timer">00:00</span>
              </div>
              <div style="display: flex; gap: 0.75rem;">
                ${this.currentQuestion > 0 ? '<button onclick="previousQuestion()" style="padding: 0.5rem 1rem; border: 2px solid #6b7280; background: none; border-radius: 6px; cursor: pointer;">Anterior</button>' : ''}
                <button id="next-btn" onclick="nextQuestion()" disabled style="padding: 0.5rem 1rem; background: #d1d5db; color: #9ca3af; border: none; border-radius: 6px; cursor: not-allowed;">
                  ${this.currentQuestion === questions.length - 1 ? 'Finalizar' : 'Próxima'}
                </button>
              </div>
            </div>
          </div>
        `;

        const modalEl = modal.show(content, { closable: false });
        this.startTimer();
      }

      generateQuestions() {
        // Simulação de questões baseadas no quiz
        const questionSets = {
          1: [ // História do Brasil
            {
              question: "Em que ano foi proclamada a Independência do Brasil?",
              options: ["1820", "1822", "1824", "1825"],
              correct: 1
            },
            {
              question: "Quem foi o primeiro presidente do Brasil?",
              options: ["Getúlio Vargas", "Deodoro da Fonseca", "Floriano Peixoto", "Dom Pedro II"],
              correct: 1
            }
          ],
          2: [ // Matemática
            {
              question: "Qual é o resultado de 2 + 2 × 3?",
              options: ["8", "12", "6", "10"],
              correct: 0
            }
          ]
        };

        return questionSets[this.currentQuiz.id] || questionSets[1];
      }

      startTimer() {
        const timerEl = document.getElementById('quiz-timer');
        if (!timerEl) return;

        const updateTimer = () => {
          const elapsed = Date.now() - this.startTime;
          const minutes = Math.floor(elapsed / 60000);
          const seconds = Math.floor((elapsed % 60000) / 1000);
          timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        };

        updateTimer();
        this.timerInterval = setInterval(updateTimer, 1000);
      }

      stopTimer() {
        if (this.timerInterval) {
          clearInterval(this.timerInterval);
          this.timerInterval = null;
        }
      }
    }

    // Instanciar sistemas avançados
    const themeSystem = new ThemeSystem();
    const quizProgress = new QuizProgress();

    // Funções globais para o sistema de quiz
    window.selectAnswer = function(optionIndex) {
      // Remover seleção anterior
      document.querySelectorAll('.quiz-option').forEach(opt => {
        opt.style.borderColor = '#e5e7eb';
        opt.style.background = 'white';
      });

      // Marcar nova seleção
      const selectedOption = document.querySelector(`[data-index="${optionIndex}"]`);
      selectedOption.style.borderColor = '#2563eb';
      selectedOption.style.background = '#eff6ff';

      // Habilitar botão próximo
      const nextBtn = document.getElementById('next-btn');
      nextBtn.disabled = false;
      nextBtn.style.background = '#2563eb';
      nextBtn.style.color = 'white';
      nextBtn.style.cursor = 'pointer';

      // Salvar resposta
      quizProgress.answers[quizProgress.currentQuestion] = optionIndex;
    };

    window.nextQuestion = function() {
      const questions = quizProgress.generateQuestions();
      
      if (quizProgress.currentQuestion < questions.length - 1) {
        quizProgress.currentQuestion++;
        quizProgress.showQuestionInterface();
      } else {
        // Finalizar quiz
        quizProgress.stopTimer();
        showQuizResults();
      }
    };

    window.previousQuestion = function() {
      if (quizProgress.currentQuestion > 0) {
        quizProgress.currentQuestion--;
        quizProgress.showQuestionInterface();
      }
    };

    function showQuizResults() {
      const questions = quizProgress.generateQuestions();
      const correctAnswers = quizProgress.answers.filter((answer, index) => 
        answer === questions[index].correct
      ).length;
      
      const percentage = Math.round((correctAnswers / questions.length) * 100);
      const totalTime = Date.now() - quizProgress.startTime;
      const minutes = Math.floor(totalTime / 60000);
      const seconds = Math.floor((totalTime % 60000) / 1000);

      const performance = percentage >= 80 ? 'Excelente!' : percentage >= 60 ? 'Bom!' : 'Precisa melhorar';
      const performanceColor = percentage >= 80 ? '#10b981' : percentage >= 60 ? '#f59e0b' : '#ef4444';

      const content = `
        <div style="text-align: center;">
          <div style="font-size: 4rem; margin-bottom: 1rem;">
            ${percentage >= 80 ? '🏆' : percentage >= 60 ? '👍' : '📚'}
          </div>
          <h3 style="color: ${performanceColor}; margin-bottom: 0.5rem; font-size: 1.5rem;">${performance}</h3>
          <p style="color: #64748b; margin-bottom: 1.5rem;">Você completou o quiz "${quizProgress.currentQuiz.title}"</p>
          
          <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <div style="font-size: 1.5rem; font-weight: 700; color: ${performanceColor};">${percentage}%</div>
              <div style="font-size: 0.875rem; color: #64748b;">Aproveitamento</div>
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <div style="font-size: 1.5rem; font-weight: 700; color: #2563eb;">${correctAnswers}/${questions.length}</div>
              <div style="font-size: 0.875rem; color: #64748b;">Acertos</div>
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <div style="font-size: 1.5rem; font-weight: 700; color: #6b7280;">${minutes}:${seconds.toString().padStart(2, '0')}</div>
              <div style="font-size: 0.875rem; color: #64748b;">Tempo total</div>
            </div>
            <div style="background: #f8fafc; padding: 1rem; border-radius: 8px;">
              <div style="font-size: 1.5rem; font-weight: 700; color: #f59e0b;">+${Math.floor(percentage * 0.8)}</div>
              <div style="font-size: 0.875rem; color: #64748b;">Pontos XP</div>
            </div>
          </div>

          <div style="display: flex; gap: 0.75rem; justify-content: center;">
            <button onclick="reviewAnswers()" style="background: #64748b; color: white; border: none; padding: 0.75rem 1rem; border-radius: 8px; cursor: pointer;">
              📋 Revisar Respostas
            </button>
            <button onclick="shareResult()" style="background: #2563eb; color: white; border: none; padding: 0.75rem 1rem; border-radius: 8px; cursor: pointer;">
              📤 Compartilhar
            </button>
            <button onclick="modal.hide(); notifications.show('Parabéns pelo quiz!', 'success')" style="background: #10b981; color: white; border: none; padding: 0.75rem 1rem; border-radius: 8px; cursor: pointer;">
              ✅ Concluir
            </button>
          </div>
        </div>
      `;

      modal.show(content);
    }

    window.reviewAnswers = function() {
      const questions = quizProgress.generateQuestions();
      const reviewContent = `
        <div>
          <h3 style="margin-bottom: 1rem; color: #1e293b;">📋 Revisão das Respostas</h3>
          <div style="max-height: 400px; overflow-y: auto;">
            ${questions.map((q, index) => {
              const userAnswer = quizProgress.answers[index];
              const isCorrect = userAnswer === q.correct;
              
              return `
                <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                  <div style="font-weight: 600; margin-bottom: 0.5rem; color: #1e293b;">
                    ${index + 1}. ${q.question}
                  </div>
                  <div style="font-size: 0.875rem; margin-bottom: 0.5rem;">
                    <span style="color: ${isCorrect ? '#10b981' : '#ef4444'}; font-weight: 600;">
                      ${isCorrect ? '✅ Correto' : '❌ Incorreto'}
                    </span>
                  </div>
                  <div style="font-size: 0.875rem; color: #64748b;">
                    <div><strong>Sua resposta:</strong> ${q.options[userAnswer] || 'Não respondida'}</div>
                    ${!isCorrect ? `<div><strong>Resposta correta:</strong> ${q.options[q.correct]}</div>` : ''}
                  </div>
                </div>
              `;
            }).join('')}
          </div>
          <button onclick="modal.hide()" style="width: 100%; background: #2563eb; color: white; border: none; padding: 0.75rem; border-radius: 8px; cursor: pointer; margin-top: 1rem;">
            Fechar Revisão
          </button>
        </div>
      `;
      modal.show(reviewContent);
    };

    window.shareResult = function() {
      const percentage = Math.round((quizProgress.answers.filter((answer, index) => 
        answer === quizProgress.generateQuestions()[index].correct
      ).length / quizProgress.generateQuestions().length) * 100);

      const shareText = `Acabei de completar o quiz "${quizProgress.currentQuiz.title}" no DX Quiz Platform e consegui ${percentage}% de aproveitamento! 🎉`;
      
      if (navigator.share) {
        navigator.share({
          title: 'Meu resultado no DX Quiz',
          text: shareText,
          url: window.location.href
        });
      } else if (navigator.clipboard) {
        navigator.clipboard.writeText(shareText);
        notifications.show('Resultado copiado para a área de transferência!', 'success');
      } else {
        // Fallback para browsers mais antigos
        const tempInput = document.createElement('input');
        tempInput.value = shareText;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        notifications.show('Resultado copiado para a área de transferência!', 'success');
      }
    };

    // Sistema de shortcuts de teclado
    document.addEventListener('keydown', (e) => {
      // Ctrl/Cmd + K para busca
      if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('quiz-search');
        if (searchInput) {
          searchInput.focus();
          notifications.show('Digite para buscar quizes...', 'info', 2000);
        }
      }
      
      // Ctrl/Cmd + N para novo quiz
      if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        document.querySelector('.create-quiz-card')?.click();
      }
      
      // Ctrl/Cmd + D para alternar tema
      if ((e.ctrlKey || e.metaKey) && e.key === 'd') {
        e.preventDefault();
        themeSystem.toggle();
      }

      // ESC para fechar modal
      if (e.key === 'Escape' && modal.activeModal) {
        modal.hide();
      }
    });

    // Sistema de cache local para performance
    class CacheSystem {
      constructor() {
        this.cache = new Map();
        this.maxAge = 5 * 60 * 1000; // 5 minutos
      }

      set(key, value) {
        this.cache.set(key, {
          data: value,
          timestamp: Date.now()
        });
      }

      get(key) {
        const item = this.cache.get(key);
        if (!item) return null;
        
        if (Date.now() - item.timestamp > this.maxAge) {
          this.cache.delete(key);
          return null;
        }
        
        return item.data;
      }

      clear() {
        this.cache.clear();
      }
    }

    const cache = new CacheSystem();

    // Função para salvar progresso automaticamente
    function autoSave() {
      const state = {
        currentQuiz: quizProgress.currentQuiz?.id,
        currentQuestion: quizProgress.currentQuestion,
        answers: quizProgress.answers,
        theme: themeSystem.currentTheme
      };
      
      try {
        localStorage.setItem('quiz-autosave', JSON.stringify(state));
      } catch (error) {
        console.warn('Não foi possível salvar o progresso automaticamente');
      }
    }

    // Carregar progresso salvo
    function loadAutoSave() {
      try {
        const saved = localStorage.getItem('quiz-autosave');
        if (saved) {
          const state = JSON.parse(saved);
          if (state.currentQuiz && confirm('Deseja continuar o quiz onde parou?')) {
            quizProgress.currentQuiz = quizData.quizzes.find(q => q.id === state.currentQuiz);
            quizProgress.currentQuestion = state.currentQuestion;
            quizProgress.answers = state.answers;
            quizProgress.startTime = Date.now();
            quizProgress.showQuestionInterface();
          }
        }
      } catch (error) {
        console.warn('Não foi possível carregar o progresso salvo');
      }
    }

    // Salvar progresso a cada 10 segundos durante um quiz
    setInterval(() => {
      if (quizProgress.currentQuiz) {
        autoSave();
      }
    }, 10000);

    // Adicionar ao DOMContentLoaded original
    const originalDOMContentLoaded = document.addEventListener('DOMContentLoaded', () => {
      // Todo o código existente...
      
      // Carregar autosave após 2 segundos
      setTimeout(loadAutoSave, 2000);
      
      // Adicionar dica de shortcuts
      setTimeout(() => {
        notifications.show('💡 Dica: Use Ctrl+K para buscar, Ctrl+N para criar quiz!', 'info', 4000);
      }, 5000);
    });

    // Override da função startQuiz para usar o sistema avançado
    window.startQuiz = function(quizId) {
      modal.hide();
      quizProgress.startQuiz(quizId);
    };

    console.log('🎯 Dashboard Quiz System v2.0 - Totalmente funcional!');
  </script>
</body>
</html>