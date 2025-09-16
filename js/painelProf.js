
        const $ = (sel) => document.querySelector(sel);
        const $$ = (sel) => Array.from(document.querySelectorAll(sel));

        const admin = {
            // ===== Navegação =====
            showSection(id) {
                $$('.section').forEach(s => s.classList.remove('active'));
                $('#' + id).classList.add('active');
                $$('.nav-link').forEach(n => n.classList.remove('active'));
                const link = $$('.nav-link').find(a => a.getAttribute('onclick')?.includes(`'${id}'`));
                if (link) link.classList.add('active');

                // carregamentos sob demanda
                if (id === 'turmas') this.loadTurmas();
                if (id === 'alunos') this.loadAlunos();
                if (id === 'quizzes') this.loadQuizzes();
                if (id === 'dashboard') this.loadDashboard();
            },

            // ===== Modais =====
            showModal(id) { $('#' + id).classList.add('open'); },
            closeModal(id) { $('#' + id).classList.remove('open'); },

            // ===== Util =====
            async api(action, data = {}, method = 'POST') {
                const opts = { method };
                const body = new URLSearchParams({ action, ...data });
                if (method === 'POST') {
                    opts.headers = { 'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8' };
                    opts.body = body.toString();
                } else {
                    // GET
                    const url = 'api.php?' + body.toString();
                    const res = await fetch(url, { credentials: 'same-origin' });

                    return res.json();
                }
                const res = await fetch('api.php', { ...opts, credentials: 'same-origin' });
                return res.json();
            },

            toast(msg, type = 'info') {
                alert(msg);
            },

            // ===== Sessão =====
            async initMe() {
                const res = await this.api('me', {}, 'GET').catch(() => null);
                if (!res || !res.ok) {
                    this.toast('Faça login para acessar o painel.', 'warn');
                    return false;
                }
                const me = res.me;
                $('#professorName').textContent = me.nome || 'Professor(a)';
                $('#professorEmail').textContent = me.email || '';
                const avatar = (me.avatar || '').trim();
                const inicial = (me.nome || 'P').trim().charAt(0).toUpperCase();
                $('#userAvatar').textContent = inicial;
                return true;
            },

            async logout() {
                await this.api('logout', {}, 'POST');
                window.location.reload();
            },

            // ===== Dashboard =====
            async loadDashboard() {
            const res = await this.api('dashboard_stats', {}, 'GET');
                if (!res || !res.ok) {
                    this.toast('Erro ao carregar estatísticas. Faça login novamente.', 'error');
                    return;
                }
                const s = res.stats;
                $('#totalTurmas').textContent = s.totalTurmas ?? 0;
                $('#totalAlunos').textContent = s.totalAlunos ?? 0;
                $('#totalQuizzes').textContent = s.totalQuizzes ?? 0;
                $('#mediaAproveitamento').textContent = (s.mediaAproveitamento ?? 0) + '%';
            },


            // ===== Turmas =====
            _turmasCache: [],
            async loadTurmas() {
                const searchInput = $('#turmas .search-input');
                const statusSelect = $('#turmas select');
                const search = searchInput ? searchInput.value || '' : '';
                const statusSel = statusSelect ? statusSelect.value || '' : '';
                const res = await this.api('list_turmas', { q: search, status: statusSel }, 'GET');
                if (!res.ok) return;
                this._turmasCache = res.turmas || [];
                this.renderTurmas(this._turmasCache);
            },

            renderTurmas(rows) {
                const body = $('#turmasTableBody');
                if (!body) return;
                if (!rows.length) {
                    body.innerHTML = `<tr><td colspan="7" class="loading">Nenhuma turma encontrada</td></tr>`;
                    return;
                }
                body.innerHTML = rows.map(t => `
                    <tr>
                        <td>${t.nome}</td>
                        <td><code>${t.codigo}</code></td>
                        <td>${t.serie || '-'}</td>
                        <td>${t.alunos ?? 0}</td>
                        <td><span class="badge ${t.status === 'ativa' ? 'badge-success' : 'badge-secondary'}">${t.status}</span></td>
                        <td>${t.criado_em}</td>
                        <td style="display:flex; gap:8px;">
                            <button class="btn btn-sm" onclick="admin.openTurma(${t.id})">Detalhes</button>
                        </td>
                    </tr>
                `).join('');
            },

            filterTable(tableId, text) {
                const q = (text || '').toLowerCase();
                const rows = $$('#' + tableId + ' tbody tr');
                rows.forEach(tr => {
                    const vis = tr.textContent.toLowerCase().includes(q);
                    tr.style.display = vis ? '' : 'none';
                });
            },

            filterTurmasByStatus(value) {
                const filtered = value ? this._turmasCache.filter(t => (t.status === value)) : this._turmasCache.slice();
                this.renderTurmas(filtered);
            },

            async openTurma(id) {
                const content = $('#turmaDetailsContent');
                if (!content) return;
                content.innerHTML = `<div class="loading">Carregando detalhes...</div>`;
                this.showModal('modalDetalhesTurma');
                const res = await this.api('turma_detalhes', { turma_id: id }, 'GET');
                if (!res.ok) {
                    content.innerHTML = `<div class="alert alert-error">${res.error || 'Erro'}</div>`;
                    return;
                }
                const t = res.turma;
                const alunos = res.alunos || [];
                content.innerHTML = `
                    <div class="turma-head">
                        <h4>${t.nome} <small style="font-weight:normal">(${t.serie || '-'})</small></h4>
                        <div><strong>Código:</strong> <code>${t.codigo}</code></div>
                        <div><strong>Status:</strong> <span class="badge ${t.status==='ativa'?'badge-success':'badge-secondary'}">${t.status}</span></div>
                        <div><strong>Criada em:</strong> ${t.criado_em}</div>
                        ${t.descricao ? `<p style="margin-top:8px">${t.descricao}</p>` : ''}
                    </div>
                    <hr/>
                    <h5>Alunos (${alunos.length})</h5>
                    <table class="data-table">
                        <thead><tr><th>Nome</th><th>Email</th><th>XP</th><th>Nível</th><th>Status</th></tr></thead>
                        <tbody>
                            ${
                                alunos.length
                                    ? alunos.map(a => `
                                        <tr>
                                            <td>${a.nome}</td>
                                            <td>${a.email}</td>
                                            <td>${a.xp ?? 0}</td>
                                            <td>${a.nivel ?? 1}</td>
                                            <td><span class="badge ${a.status==='ativo'?'badge-success':'badge-secondary'}">${a.status}</span></td>
                                        </tr>
                                    `).join('')
                                    : `<tr><td colspan="5" class="loading">Sem alunos na turma</td></tr>`
                            }
                        </tbody>
                    </table>
                `;
            },

            // Form Nova Turma
            initFormTurma() {
                const form = $('#formNovaTurma');
                if (!form) return;
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const payload = {
                        nome: $('#nomeTurma').value.trim(),
                        serie: $('#serieTurma').value.trim(),
                        descricao: $('#descricaoTurma').value.trim(),
                        limite: $('#limiteTurma').value.trim() || '50'
                    };
                    const res = await this.api('create_turma', payload, 'POST');
                    if (!res.ok) return this.toast(res.error || 'Erro ao criar turma', 'error');
                    this.toast('Turma criada com sucesso!', 'success');
                    this.closeModal('modalNovaTurma');
                    $('#formNovaTurma').reset();
                    this.loadTurmas();
                    this.loadDashboard();
                });
            },

            // ===== Alunos =====
            _alunosCache: [],
            async loadAlunos() {
                const searchInput = $('#alunos .search-input');
                const turmaFilter = $('#turmaFilter');
                const search = searchInput ? searchInput.value || '' : '';
                const turmaId = turmaFilter ? turmaFilter.value || '' : '';
                const res = await this.api('list_alunos', { q: search, turma_id: turmaId }, 'GET');
                if (!res.ok) return;
                this._alunosCache = res.alunos || [];
                // preencher select de turmas
                const sel = $('#turmaFilter');
                if (sel && sel.options.length <= 1) {
                    (res.turmas || []).forEach(t => {
                        const opt = document.createElement('option');
                        opt.value = t.id;
                        opt.textContent = t.nome;
                        sel.appendChild(opt);
                    });
                    // também no modal de novo aluno
                    const turmaAluno = $('#turmaAluno');
                    if (turmaAluno) {
                        (res.turmas || []).forEach(t => {
                            const opt = document.createElement('option');
                            opt.value = t.id;
                            opt.textContent = t.nome;
                            turmaAluno.appendChild(opt);
                        });
                    }
                }
                this.renderAlunos(this._alunosCache);
                console.log(res);
            },

            renderAlunos(rows) {
                const body = $('#alunosTableBody');
                if (!body) return;
                if (!rows.length) {
                    body.innerHTML = `<tr><td colspan="7" class="loading">Nenhum aluno encontrado</td></tr>`;
                    return;
                }
                body.innerHTML = rows.map(a => `
                    <tr>
                        <td>${a.nome}</td>
                        <td>${a.email}</td>
                        <td>${a.turma_nome || '-'}</td>
                        <td>${a.xp ?? 0}</td>
                        <td>${a.nivel ?? 1}</td>
                        <td><span class="badge ${a.status==='ativo'?'badge-success':'badge-secondary'}">${a.status}</span></td>
                        <td>
                            <button class="btn btn-sm btn-secondary" disabled>Editar</button>
                        </td>
                    </tr>
                `).join('');
            },

            filterAlunosByTurma(value) {
                const turmaId = parseInt(value || '0', 10);
                const filtered = turmaId ? this._alunosCache.filter(a => a.turma_id === turmaId) : this._alunosCache.slice();
                this.renderAlunos(filtered);
            },

            // Form Novo Aluno
            initFormAluno() {
                const form = $('#formNovoAluno');
                if (!form) return;
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const payload = {
                        nome: $('#nomeAluno').value.trim(),
                        email: $('#emailAluno').value.trim(),
                        senha: $('#senhaAluno').value,
                        turma_id: $('#turmaAluno').value,
                        nascimento: $('#nascimentoAluno').value
                    };
                    const res = await this.api('create_aluno', payload, 'POST');
                    if (!res.ok) return this.toast(res.error || 'Erro ao cadastrar aluno', 'error');
                    this.toast('Aluno cadastrado com sucesso!', 'success');
                    this.closeModal('modalNovoAluno');
                    form.reset();
                    this.loadAlunos();
                    this.loadDashboard();
                });
            },

            // ===== Quizzes =====
            async loadQuizzes() {
                const searchInput = $('#quizzes .search-input');
                const sel = $('#quizzes select.form-select');
                const search = searchInput ? searchInput.value || '' : '';
                const categoria = sel ? (sel.value || '') : '';
                const res = await this.api('list_quizzes', { q: search, categoria }, 'GET');
                if (!res.ok) return;
                const rows = res.quizzes || [];
                const body = $('#quizzesTableBody');
                if (!body) return;
                if (!rows.length) {
                    body.innerHTML = `<tr><td colspan="7" class="loading">Nenhum quiz encontrado</td></tr>`;
                    return;
                }
                body.innerHTML = rows.map(q => `
                    <tr>
                        <td>${q.titulo}</td>
                        <td>${q.categoria || '-'}</td>
                        <td>${q.total_questoes ?? 0}</td>
                        <td>${q.tentativas ?? 0}</td>
                        <td>${(q.taxa_sucesso ?? 0)}%</td>
                        <td><span class="badge ${q.status==='publicado'?'badge-success':'badge-secondary'}">${q.status}</span></td>
                        <td>
                            <button class="btn btn-sm btn-secondary" disabled>Abrir</button>
                        </td>
                    </tr>
                `).join('');
            },

            redirectToQuizCreator() {
                // ajuste o caminho conforme seu projeto
                window.location.href = 'criar_quiz.html';
            },

            // ===== Inicialização =====
            async init() {
                const ok = await this.initMe();
                if (!ok) return;
                this.initFormTurma();
                this.initFormAluno();
                this.loadDashboard();
                // pré-carrega turmas/alunos quando usuário abrir as seções
            }
        };

        // Expor no global para onclicks do HTML
        window.admin = admin;

        // Start quando DOM carregar
        document.addEventListener('DOMContentLoaded', () => admin.init());
    