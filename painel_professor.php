<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Didaxie - Painel do Professor</title>
    <link rel="stylesheet" href="css/painelProf.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>📚 Didaxie - Painel do Professor</h1>
            <div class="user-info">
                <div class="user-avatar" id="userAvatar">P</div>
                <div>
                    <div id="professorName">Carregando...</div>
                    <small id="professorEmail">carregando@email.com</small>
                </div>
                <button class="btn btn-secondary btn-sm" onclick="admin.logout()">Sair</button>
            </div>
        </div>

        <div class="main-content">
            <!-- Sidebar -->
            <div class="sidebar">
                <nav>
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a class="nav-link active" onclick="admin.showSection('dashboard')">
                                📊 Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="admin.showSection('turmas')">
                                🏫 Turmas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="admin.showSection('alunos')">
                                👥 Alunos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="admin.showSection('quizzes')">
                                📝 Quizzes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" onclick="admin.showSection('relatorios')">
                                📈 Relatórios
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Dashboard -->
                <div id="dashboard" class="section active">
                    <div class="section-header">
                        <h2 class="section-title">Dashboard</h2>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number" id="totalTurmas">-</div>
                            <div class="stat-label">Turmas Ativas</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="totalAlunos">-</div>
                            <div class="stat-label">Alunos Cadastrados</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="totalQuizzes">-</div>
                            <div class="stat-label">Quizzes Criados</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="mediaAproveitamento">-%</div>
                            <div class="stat-label">Aproveitamento Médio</div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>💡 Dica:</strong> Use o menu lateral para navegar entre as seções. Você pode gerenciar suas turmas, cadastrar alunos e criar quizzes educativos.
                    </div>
                </div>

                <!-- Turmas -->
                <div id="turmas" class="section">
                    <div class="section-header">
                        <h2 class="section-title">Gerenciar Turmas</h2>
                        <button class="btn" onclick="admin.showModal('modalNovaTurma')">
                            ➕ Nova Turma
                        </button>
                    </div>

                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Buscar turmas..." onkeyup="admin.filterTable('turmasTable', this.value)">
                        <select class="form-select" style="max-width: 200px;" onchange="admin.filterTurmasByStatus(this.value)">
                            <option value="">Todos os status</option>
                            <option value="ativa">Ativas</option>
                            <option value="inativa">Inativas</option>
                        </select>
                    </div>

                    <table class="data-table" id="turmasTable">
                        <thead>
                            <tr>
                                <th>Nome da Turma</th>
                                <th>Código</th>
                                <th>Série</th>
                                <th>Alunos</th>
                                <th>Status</th>
                                <th>Criada em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="turmasTableBody">
                            <tr>
                                <td colspan="7" class="loading">Carregando dados...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Alunos -->
                <div id="alunos" class="section">
                    <div class="section-header">
                        <h2 class="section-title">Gerenciar Alunos</h2>
                        <button class="btn" onclick="admin.showModal('modalNovoAluno')">
                            ➕ Novo Aluno
                        </button>
                    </div>

                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Buscar alunos..." onkeyup="admin.filterTable('alunosTable', this.value)">
                        <select class="form-select" style="max-width: 200px;" id="turmaFilter" onchange="admin.filterAlunosByTurma(this.value)">
                            <option value="">Todas as turmas</option>
                        </select>
                    </div>

                    <table class="data-table" id="alunosTable">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Turma</th>
                                <th>XP</th>
                                <th>Nível</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="alunosTableBody">
                            <tr>
                                <td colspan="7" class="loading">Carregando dados...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Quizzes -->
                <div id="quizzes" class="section">
                    <div class="section-header">
                        <h2 class="section-title">Meus Quizzes</h2>
                        <button class="btn" onclick="admin.redirectToQuizCreator()">
                            ➕ Criar Quiz
                        </button>
                    </div>

                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Buscar quizzes..." onkeyup="admin.filterTable('quizzesTable', this.value)">
                        <select class="form-select" style="max-width: 200px;">
                            <option value="">Todas as categorias</option>
                            <option value="historia">História</option>
                            <option value="matematica">Matemática</option>
                            <option value="ciencias">Ciências</option>
                        </select>
                    </div>

                    <table class="data-table" id="quizzesTable">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Categoria</th>
                                <th>Questões</th>
                                <th>Tentativas</th>
                                <th>Taxa de Sucesso</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="quizzesTableBody">
                            <tr>
                                <td colspan="7" class="loading">Carregando dados...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Relatórios -->
                <div id="relatorios" class="section">
                    <div class="section-header">
                        <h2 class="section-title">Relatórios</h2>
                    </div>

                    <div class="alert alert-info">
                        <strong>📊 Relatórios Disponíveis:</strong> Esta seção conterá relatórios detalhados sobre o desempenho dos alunos, estatísticas dos quizzes e análises de progresso.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nova Turma -->
    <div id="modalNovaTurma" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Criar Nova Turma</h3>
                <button class="close-btn" onclick="admin.closeModal('modalNovaTurma')">&times;</button>
            </div>
            
            <form id="formNovaTurma">
                <div class="form-group">
                    <label class="form-label">Nome da Turma *</label>
                    <input type="text" class="form-input" id="nomeTurma" required placeholder="Ex: 1º Ano A - Ensino Médio">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Ano/Série *</label>
                    <select class="form-select" id="serieTurma" required>
                        <option value="">Selecione...</option>
                        <option value="6º Ano">6º Ano</option>
                        <option value="7º Ano">7º Ano</option>
                        <option value="8º Ano">8º Ano</option>
                        <option value="9º Ano">9º Ano</option>
                        <option value="1º Ano EM">1º Ano EM</option>
                        <option value="2º Ano EM">2º Ano EM</option>
                        <option value="3º Ano EM">3º Ano EM</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-input form-textarea" id="descricaoTurma" placeholder="Descrição da turma (opcional)"></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Limite de Alunos</label>
                    <input type="number" class="form-input" id="limiteTurma" value="50" min="1" max="100">
                </div>
                
                <div style="text-align: right; gap: 10px; display: flex; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="admin.closeModal('modalNovaTurma')">Cancelar</button>
                    <button type="submit" class="btn btn-success">Criar Turma</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Novo Aluno -->
    <div id="modalNovoAluno" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cadastrar Novo Aluno</h3>
                <button class="close-btn" onclick="admin.closeModal('modalNovoAluno')">&times;</button>
            </div>
            
            <form id="formNovoAluno">
                <div class="form-group">
                    <label class="form-label">Nome Completo *</label>
                    <input type="text" class="form-input" id="nomeAluno" required placeholder="Nome completo do aluno">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" class="form-input" id="emailAluno" required placeholder="email@exemplo.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Senha Inicial *</label>
                    <input type="password" class="form-input" id="senhaAluno" required placeholder="Senha inicial">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Turma *</label>
                    <select class="form-select" id="turmaAluno" required>
                        <option value="">Selecione uma turma...</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-input" id="nascimentoAluno">
                </div>
                
                <div style="text-align: right; gap: 10px; display: flex; justify-content: flex-end;">
                    <button type="button" class="btn btn-secondary" onclick="admin.closeModal('modalNovoAluno')">Cancelar</button>
                    <button type="submit" class="btn btn-success">Cadastrar Aluno</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detalhes da Turma -->
    <div id="modalDetalhesTurma" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detalhes da Turma</h3>
                <button class="close-btn" onclick="admin.closeModal('modalDetalhesTurma')">&times;</button>
            </div>
            
            <div id="turmaDetailsContent">
                <div class="loading">Carregando detalhes...</div>
            </div>
        </div>
    </div>

    <script src="./js/painelProf.js"></script>
    <script>
const API = 'api.php'; // apontando para o endpoint separado

// Atualize todas as chamadas de fetch do JS:
admin.api = async function(action, data={}, method='POST') {
    const opts = { method };
    const body = new URLSearchParams({ action, ...data });
    if (method==='POST') {
        opts.headers = { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' };
        opts.body = body.toString();
    } else {
        const url = API + '?' + body.toString();
        const res = await fetch(url, { credentials:'same-origin' });
        return res.json();
    }
    const res = await fetch(API, {...opts, credentials:'same-origin'});
    return res.json();
}
document.addEventListener('DOMContentLoaded', () => admin.init());
</script>
</body>
</html>