<?php
session_start();
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'didaxie';

// Conectar ao banco
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
    die("Erro ao conectar no MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8mb4");

// Pegar o código do quiz (exemplo: via GET ou sessão)
$codigo = $_GET['codigo'] ?? $_SESSION['codigo_quiz'] ?? null;
if (!$codigo) {
    die("Código do quiz não fornecido.");
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_aluno.php?codigo=" . urlencode($_GET['codigo'] ?? ''));
    exit;
}

// Buscar o ID do quiz pelo código
$stmt = $mysqli->prepare("SELECT id FROM quizzes WHERE codigo = ?");
$stmt->bind_param("s", $codigo);
$stmt->execute();
$result = $stmt->get_result();
$quiz = $result->fetch_assoc();
if (!$quiz) {
    die("Quiz não encontrado.");
}
$quiz_id = $quiz['id'];

// Buscar perguntas e respostas
$stmt = $mysqli->prepare("
    SELECT q.id AS questao_id, q.enunciado, r.id AS resposta_id, r.texto, r.correta
    FROM questoes q
    LEFT JOIN respostas r ON r.questao_id = q.id
    WHERE q.quiz_id = ?
    ORDER BY q.id, r.id
");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();

// Organizar em array de perguntas com respostas
$perguntas = [];
while ($row = $result->fetch_assoc()) {
    $qid = $row['questao_id'];
    if (!isset($perguntas[$qid])) {
        $perguntas[$qid] = [
            'pergunta' => $row['enunciado'],
            'opcoes' => [],
            'correta' => null
        ];
    }
    if ($row['resposta_id']) {
        $perguntas[$qid]['opcoes'][] = $row['texto'];
        if ($row['correta']) {
            $perguntas[$qid]['correta'] = count($perguntas[$qid]['opcoes']) - 1;
        }
    }
}

// Reindexar array para JavaScript
$perguntas = array_values($perguntas);

// Transformar em JSON para o JS
$perguntas_json = json_encode($perguntas, JSON_UNESCAPED_UNICODE);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jogo de Equipes</title>
  <link rel="stylesheet" href="css/jogo1.css">
</head>
<body>
  <main>
    <!-- Cadastro -->
    <section id="cadastro" class="fase ativa">
      <h2>Cadastro de Jogadores</h2>
      <div>
        <label for="nomeJogador">Nome:</label>
        <input type="text" id="nomeJogador" placeholder="Nome do jogador">
        <button class="botao" onclick="jogo.adicionarJogador()">Adicionar</button>
      </div>
      <ul id="listaJogadores"></ul>
      <p>Total de jogadores: <span id="contadorJogadores">0</span></p>
      <button id="iniciarDivisao" class="botao" onclick="jogo.irParaDivisao()" disabled>Próxima Fase</button>
    </section>

    <!-- Divisao -->
    <section id="divisao" class="fase">
      <h2>Divisão de Equipes</h2>
      <div class="equipes">
        <div class="equipe-info">
          <h3>Equipe 1</h3>
          <input type="text" id="nomeEquipe1" value="Equipe A" placeholder="Nome da equipe">
          <ul id="equipe1"></ul>
          <p>Jogadores: <span id="contadorEquipe1">0</span></p>
        </div>
        <div class="equipe-info">
          <h3>Equipe 2</h3>
          <input type="text" id="nomeEquipe2" value="Equipe B" placeholder="Nome da equipe">
          <ul id="equipe2"></ul>
          <p>Jogadores: <span id="contadorEquipe2">0</span></p>
        </div>
      </div>
      <button class="botao" onclick="jogo.embaralharEquipes()">Embaralhar</button>
      <button id="iniciarJogo" class="botao" onclick="jogo.irParaJogo()" disabled>Iniciar Jogo</button>
    </section>

    <!-- Jogo -->
    <section id="jogo" class="fase">
      <h2 id="tituloRodada">Rodada <span id="numeroRodada">1</span></h2>
      <div id="timer">15</div>
      <div id="progressoContainer">
        <div id="progresso"></div>
      </div>
      <p id="perguntaTexto">Pergunta...</p>
      <div id="opcoesRespostas"></div>
      
      <!-- Power-ups da Equipe 1 -->
      <div id="powerUpsEquipe1" class="power-ups power-ups-equipe1">
        <h4>
          <span style="background-color: #007bff; color: white; padding: 4px 8px; border-radius: 4px; font-size: 14px;">EQUIPE 1</span>
          Power-ups:
        </h4>
        <button onclick="jogo.usarPowerUp('congelar', 1)">⏸️ Congelar Tempo</button>
        <button onclick="jogo.usarPowerUp('trocar', 1)">🔄 Trocar Pergunta</button>
        <button onclick="jogo.usarPowerUp('dobrar', 1)">⭐ Dobrar Pontos</button>
        <div class="power-up-status" id="statusPowerUpsEquipe1"></div>
      </div>

      <!-- Power-ups da Equipe 2 -->
      <div id="powerUpsEquipe2" class="power-ups power-ups-equipe2">
        <h4>
          <span style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 14px;">EQUIPE 2</span>
          Power-ups:
        </h4>
        <button onclick="jogo.usarPowerUp('congelar', 2)">⏸️ Congelar Tempo</button>
        <button onclick="jogo.usarPowerUp('trocar', 2)">🔄 Trocar Pergunta</button>
        <button onclick="jogo.usarPowerUp('dobrar', 2)">⭐ Dobrar Pontos</button>
        <div class="power-up-status" id="statusPowerUpsEquipe2"></div>
      </div>

      <div id="feedback"></div>
      <div id="pontuacaoAtual"></div>
    </section>

    <!-- Resultado -->
    <section id="resultadoFinal" class="fase">
      <h2>🏆 Resultado Final</h2>
      <div id="resumoPontuacoes"></div>
      <div id="equipeVencedora"></div>
      <button class="botao" onclick="location.reload()">🔄 Reiniciar Jogo</button>
    </section>
  </main>

  <script>
    // Objeto principal do jogo
    const jogo = {
      // Dados do jogo
      jogadores: [],
      perguntas: <?= $perguntas_json ?>,
      
      // Estado do jogo
      perguntaAtual: 0,
      intervalo: null,
      tempoTotal: 15,
      tempoRestante: 15,
      pontuacaoEquipe1: 0,
      pontuacaoEquipe2: 0,
      equipeAtual: 1,
      segundaChanceAtiva: false,
      
      // Power-ups independentes para cada equipe
      powerUpsEquipe1: { congelar: false, trocar: false, dobrar: false },
      powerUpsEquipe2: { congelar: false, trocar: false, dobrar: false },
      powerUpDobrarAtivo: { equipe: 0 }, // 0 = nenhuma, 1 = equipe1, 2 = equipe2
      
      equipes: {
        equipe1: { nome: "Equipe A", jogadores: [] },
        equipe2: { nome: "Equipe B", jogadores: [] }
      },

      // Função segura para obter elementos
      getElement: function(id) {
        const element = document.getElementById(id);
        if (!element) {
          console.warn(`Elemento com ID '${id}' não encontrado`);
        }
        return element;
      },

      // Função segura para definir texto
      setText: function(id, text) {
        const element = this.getElement(id);
        if (element) {
          element.textContent = text;
          return true;
        }
        return false;
      },

      // Função segura para definir HTML
      setHTML: function(id, html) {
        const element = this.getElement(id);
        if (element) {
          element.innerHTML = html;
          return true;
        }
        return false;
      },

      // Funções de controle de fases
      mostrarFase: function(faseAtiva) {
        try {
          document.querySelectorAll('.fase').forEach(fase => {
            fase.classList.remove('ativa');
          });
          const faseElement = this.getElement(faseAtiva);
          if (faseElement) {
            faseElement.classList.add('ativa');
          }
        } catch (error) {
          console.error('Erro ao mostrar fase:', error);
        }
      },

      // Funções de cadastro
      atualizarListaJogadores: function() {
        const ul = this.getElement("listaJogadores");
        if (!ul) return;
        
        ul.innerHTML = "";
        this.jogadores.forEach((nome, index) => {
          const li = document.createElement("li");
          li.className = "jogador-item";
          
          const span = document.createElement("span");
          span.textContent = nome;
          
          const btn = document.createElement("button");
          btn.textContent = "Remover";
          btn.className = "remove-btn";
          btn.onclick = () => this.removerJogador(index);
          
          li.appendChild(span);
          li.appendChild(btn);
          ul.appendChild(li);
        });
        
        this.setText("contadorJogadores", this.jogadores.length);
        
        const btnIniciar = this.getElement("iniciarDivisao");
        if (btnIniciar) {
          btnIniciar.disabled = this.jogadores.length < 2;
        }
      },

      adicionarJogador: function() {
        const nomeInput = this.getElement("nomeJogador");
        if (!nomeInput) return;
        
        const nome = nomeInput.value.trim();
        
        if (!nome) {
          alert("Por favor, digite um nome válido.");
          return;
        }
        
        if (this.jogadores.map(j => j.toLowerCase()).includes(nome.toLowerCase())) {
          alert("Este nome já foi adicionado.");
          return;
        }
        
        this.jogadores.push(nome);
        nomeInput.value = "";
        nomeInput.focus();
        this.atualizarListaJogadores();
      },

      removerJogador: function(index) {
        if(confirm("Deseja realmente remover este jogador?")) {
          this.jogadores.splice(index, 1);
          this.atualizarListaJogadores();
        }
      },

      // Funções de divisão de equipes
      irParaDivisao: function() {
        this.mostrarFase('divisao');
        this.embaralharEquipes();
      },

      embaralharEquipes: function() {
        const embaralhado = [...this.jogadores].sort(() => Math.random() - 0.5);
        const meio = Math.ceil(embaralhado.length / 2);
        this.equipes.equipe1.jogadores = embaralhado.slice(0, meio);
        this.equipes.equipe2.jogadores = embaralhado.slice(meio);
        this.atualizarEquipes();
      },

      atualizarEquipes: function() {
        const ul1 = this.getElement("equipe1");
        const ul2 = this.getElement("equipe2");
        
        if (ul1) {
          ul1.innerHTML = "";
          this.equipes.equipe1.jogadores.forEach(j => {
            const li = document.createElement("li");
            li.textContent = j;
            li.style.padding = "5px";
            li.style.borderBottom = "1px solid #eee";
            ul1.appendChild(li);
          });
        }
        
        if (ul2) {
          ul2.innerHTML = "";
          this.equipes.equipe2.jogadores.forEach(j => {
            const li = document.createElement("li");
            li.textContent = j;
            li.style.padding = "5px";
            li.style.borderBottom = "1px solid #eee";
            ul2.appendChild(li);
          });
        }
        
        this.setText("contadorEquipe1", this.equipes.equipe1.jogadores.length);
        this.setText("contadorEquipe2", this.equipes.equipe2.jogadores.length);

        const input1 = this.getElement("nomeEquipe1");
        const input2 = this.getElement("nomeEquipe2");
        
        if (input1) this.equipes.equipe1.nome = input1.value.trim() || "Equipe A";
        if (input2) this.equipes.equipe2.nome = input2.value.trim() || "Equipe B";

        const valido = this.equipes.equipe1.jogadores.length > 0 &&
                      this.equipes.equipe2.jogadores.length > 0 &&
                      this.equipes.equipe1.nome !== this.equipes.equipe2.nome &&
                      this.equipes.equipe1.nome.length > 0 &&
                      this.equipes.equipe2.nome.length > 0;

        const btnIniciarJogo = this.getElement("iniciarJogo");
        if (btnIniciarJogo) {
          btnIniciarJogo.disabled = !valido;
        }
      },

      // Funções do jogo
      irParaJogo: function() {
        this.mostrarFase('jogo');
        this.resetarEstadoJogo();
        this.mostrarPergunta();
      },

      resetarEstadoJogo: function() {
        this.perguntaAtual = 0;
        this.pontuacaoEquipe1 = 0;
        this.pontuacaoEquipe2 = 0;
        this.equipeAtual = 1;
        this.segundaChanceAtiva = false;
        this.powerUpsEquipe1 = { congelar: false, trocar: false, dobrar: false };
        this.powerUpsEquipe2 = { congelar: false, trocar: false, dobrar: false };
        this.powerUpDobrarAtivo = { equipe: 0 };
        this.atualizarBotoesPowerUps();
      },

      mostrarPergunta: function() {
        clearInterval(this.intervalo);
        this.tempoRestante = this.tempoTotal;

        if (this.perguntaAtual >= this.perguntas.length) {
          this.mostrarResultadoFinal();
          return;
        }

        const p = this.perguntas[this.perguntaAtual];
        
        // Atualizar elementos do jogo de forma segura
        this.setText("numeroRodada", this.perguntaAtual + 1);
        this.setText("perguntaTexto", p.pergunta);
        this.setText("feedback", "");
        this.setText("pontuacaoAtual", "");
        
        // Criar opções de resposta
        const opcoesContainer = this.getElement("opcoesRespostas");
        if (opcoesContainer) {
          opcoesContainer.innerHTML = "";
          p.opcoes.forEach((opcao, index) => {
            const btn = document.createElement("button");
            btn.textContent = opcao;
            btn.onclick = () => this.responder(index);
            opcoesContainer.appendChild(btn);
          });
        }

        this.atualizarBotoesPowerUps();
        this.mostrarEquipeAtual();
        this.mostrarPowerUpsAtivos();
        this.iniciarTimer();
      },

      mostrarEquipeAtual: function() {
        const nomeEquipe = this.equipeAtual === 1 ? this.equipes.equipe1.nome : this.equipes.equipe2.nome;
        this.setHTML("tituloRodada", 
          `Rodada ${this.perguntaAtual + 1} - Turno da <span style="color: ${this.equipeAtual === 1 ? '#007bff' : '#28a745'}">${nomeEquipe}</span>`);
      },

      mostrarPowerUpsAtivos: function() {
        const powerUps1 = this.getElement("powerUpsEquipe1");
        const powerUps2 = this.getElement("powerUpsEquipe2");
        
        // Esconder ambos primeiro
        if (powerUps1) powerUps1.classList.remove('ativa');
        if (powerUps2) powerUps2.classList.remove('ativa');
        
        // Mostrar apenas da equipe atual
        if (this.equipeAtual === 1 && powerUps1) {
          powerUps1.classList.add('ativa');
          // Atualizar nome da equipe no cabeçalho
          const span = powerUps1.querySelector('span');
          if (span) span.textContent = this.equipes.equipe1.nome.toUpperCase();
        } else if (this.equipeAtual === 2 && powerUps2) {
          powerUps2.classList.add('ativa');
          // Atualizar nome da equipe no cabeçalho
          const span = powerUps2.querySelector('span');
          if (span) span.textContent = this.equipes.equipe2.nome.toUpperCase();
        }
      },

      bloquearBotoesResposta: function() {
        const botoes = document.querySelectorAll("#opcoesRespostas button");
        botoes.forEach(btn => btn.disabled = true);
      },

      desbloquearBotoesResposta: function() {
        const botoes = document.querySelectorAll("#opcoesRespostas button");
        botoes.forEach(btn => btn.disabled = false);
      },

      adicionarPontuacao: function(pontos) {
        if (this.equipeAtual === 1) {
          this.pontuacaoEquipe1 += pontos;
        } else {
          this.pontuacaoEquipe2 += pontos;
        }
      },

      responder: function(indice) {
        this.bloquearBotoesResposta();
        clearInterval(this.intervalo);

        const correta = this.perguntas[this.perguntaAtual].correta;
        let pontos = indice === correta ? 1000 : 0;
        let feedback = "";

        // Verificar se há power-up de dobrar ativo para a equipe atual
        if (this.powerUpDobrarAtivo.equipe === this.equipeAtual && pontos > 0) {
          pontos *= 2;
          this.powerUpDobrarAtivo.equipe = 0;
          if (this.equipeAtual === 1) {
            this.powerUpsEquipe1.dobrar = true;
          } else {
            this.powerUpsEquipe2.dobrar = true;
          }
          this.atualizarBotoesPowerUps();
          feedback = "Correto! Pontos dobrados! 🌟";
        } else if (pontos > 0) {
          feedback = "Correto! ✅";
        } else {
          feedback = "Errado ❌";
        }

        this.setText("feedback", feedback);

        if (pontos > 0) {
          this.adicionarPontuacao(pontos);
          this.segundaChanceAtiva = false;
          setTimeout(() => this.avancarRodada(), 2000);
        } else {
          if (!this.segundaChanceAtiva) {
            this.segundaChanceAtiva = true;
            this.equipeAtual = this.equipeAtual === 1 ? 2 : 1;
            this.setText("feedback", "Errado ❌ Segunda chance para a outra equipe! ⏰");
            setTimeout(() => {
              this.mostrarEquipeAtual();
              this.mostrarPowerUpsAtivos();
              this.iniciarTimer(8);
              this.desbloquearBotoesResposta();
            }, 1500);
          } else {
            this.segundaChanceAtiva = false;
            setTimeout(() => this.avancarRodada(), 2000);
          }
        }

        this.setText("pontuacaoAtual", `Pontuação desta pergunta: ${pontos} pontos`);
      },

      avancarRodada: function() {
        this.perguntaAtual++;
        this.equipeAtual = this.perguntaAtual % 2 === 1 ? 1 : 2;
        
        if (this.perguntaAtual < this.perguntas.length) {
          this.mostrarPergunta();
        } else {
          this.mostrarResultadoFinal();
        }
      },

      iniciarTimer: function(tempo = this.tempoTotal) {
        clearInterval(this.intervalo);
        this.tempoRestante = tempo;
        const tempoInicial = tempo;

        this.setText("timer", this.tempoRestante);
        
        const progresso = this.getElement("progresso");
        if (progresso) {
          progresso.style.width = "100%";
          progresso.style.backgroundColor = "green";
        }

        this.intervalo = setInterval(() => {
          this.tempoRestante--;
          this.setText("timer", this.tempoRestante);
          
          const perc = (this.tempoRestante / tempoInicial) * 100;
          if (progresso) {
            progresso.style.width = perc + "%";
            
            if (perc <= 25) {
              progresso.style.backgroundColor = "red";
            } else if (perc <= 50) {
              progresso.style.backgroundColor = "orange";
            } else {
              progresso.style.backgroundColor = "green";
            }
          }

          if (this.tempoRestante <= 0) {
            clearInterval(this.intervalo);
            this.bloquearBotoesResposta();

            if (!this.segundaChanceAtiva) {
              this.segundaChanceAtiva = true;
              this.equipeAtual = this.equipeAtual === 1 ? 2 : 1;
              this.setText("feedback", "Tempo esgotado! Segunda chance para a outra equipe! ⏰");
              setTimeout(() => {
                this.mostrarEquipeAtual();
                this.mostrarPowerUpsAtivos();
                this.desbloquearBotoesResposta();
                this.iniciarTimer(8);
              }, 1500);
            } else {
              this.segundaChanceAtiva = false;
              this.setText("feedback", "Tempo esgotado na segunda chance! ⏰");
              setTimeout(() => {
                this.avancarRodada();
              }, 2000);
            }
          }
        }, 1000);
      },

      // Power-ups
      usarPowerUp: function(tipo, equipe) {
        const powerUpsEquipe = equipe === 1 ? this.powerUpsEquipe1 : this.powerUpsEquipe2;
        
        if (powerUpsEquipe[tipo]) {
          alert("Esta equipe já usou este power-up nesta partida!");
          return;
        }
        
        if (equipe !== this.equipeAtual) {
          alert("Apenas a equipe da vez pode usar power-ups!");
          return;
        }
        
        const botoesAtivos = [...document.querySelectorAll("#opcoesRespostas button")].some(b => !b.disabled);
        if (!botoesAtivos) {
          alert("Power-ups só podem ser usados antes de responder a pergunta!");
          return;
        }

        switch (tipo) {
          case 'congelar':
            this.congelarTempo(equipe);
            break;
          case 'trocar':
            this.trocarPergunta(equipe);
            break;
          case 'dobrar':
            this.dobrarPontos(equipe);
            break;
        }

        powerUpsEquipe[tipo] = true;
        this.atualizarBotoesPowerUps();
      },

      congelarTempo: function(equipe) {
        clearInterval(this.intervalo);
        const nomeEquipe = equipe === 1 ? this.equipes.equipe1.nome : this.equipes.equipe2.nome;
        this.setText("feedback", `⏸️ ${nomeEquipe} congelou o tempo por 10 segundos!`);
        
        setTimeout(() => {
          this.setText("feedback", "Tempo retomado! ▶️");
          setTimeout(() => {
            this.setText("feedback", "");
            this.iniciarTimer(this.tempoRestante);
          }, 1000);
        }, 10000);
      },

      trocarPergunta: function(equipe) {
        const nomeEquipe = equipe === 1 ? this.equipes.equipe1.nome : this.equipes.equipe2.nome;
        this.setText("feedback", `🔄 ${nomeEquipe} trocou a pergunta!`);
        
        this.perguntaAtual++;
        if (this.perguntaAtual >= this.perguntas.length) {
          this.mostrarResultadoFinal();
        } else {
          setTimeout(() => {
            this.mostrarPergunta();
          }, 1000);
        }
      },

      dobrarPontos: function(equipe) {
        this.powerUpDobrarAtivo.equipe = equipe;
        const nomeEquipe = equipe === 1 ? this.equipes.equipe1.nome : this.equipes.equipe2.nome;
        this.setText("feedback", `⭐ ${nomeEquipe}: Próxima resposta correta valerá pontos em dobro!`);
      },

      atualizarBotoesPowerUps: function() {
        // Atualizar botões da Equipe 1
        const botoesEquipe1 = document.querySelectorAll("#powerUpsEquipe1 button");
        const tiposEquipe1 = ["congelar", "trocar", "dobrar"];
        
        botoesEquipe1.forEach((btn, index) => {
          const tipo = tiposEquipe1[index];
          btn.disabled = this.powerUpsEquipe1[tipo];
          
          if (this.powerUpsEquipe1[tipo] && !btn.textContent.includes("(Usado)")) {
            btn.textContent = btn.textContent.replace(/\s*\(Usado\)$/, "") + " (Usado)";
          }
        });

        // Atualizar botões da Equipe 2
        const botoesEquipe2 = document.querySelectorAll("#powerUpsEquipe2 button");
        const tiposEquipe2 = ["congelar", "trocar", "dobrar"];
        
        botoesEquipe2.forEach((btn, index) => {
          const tipo = tiposEquipe2[index];
          btn.disabled = this.powerUpsEquipe2[tipo];
          
          if (this.powerUpsEquipe2[tipo] && !btn.textContent.includes("(Usado)")) {
            btn.textContent = btn.textContent.replace(/\s*\(Usado\)$/, "") + " (Usado)";
          }
        });

        // Atualizar status dos power-ups
        this.atualizarStatusPowerUps();
      },

      atualizarStatusPowerUps: function() {
        const usadosEquipe1 = Object.values(this.powerUpsEquipe1).filter(usado => usado).length;
        const usadosEquipe2 = Object.values(this.powerUpsEquipe2).filter(usado => usado).length;
        
        this.setText("statusPowerUpsEquipe1", `Power-ups usados: ${usadosEquipe1}/3`);
        this.setText("statusPowerUpsEquipe2", `Power-ups usados: ${usadosEquipe2}/3`);
      },

      // Resultado final
      mostrarResultadoFinal: function() {
        clearInterval(this.intervalo);
        this.mostrarFase('resultadoFinal');

        // Calcular estatísticas dos power-ups
        const powerUpsUsadosEquipe1 = Object.values(this.powerUpsEquipe1).filter(usado => usado).length;
        const powerUpsUsadosEquipe2 = Object.values(this.powerUpsEquipe2).filter(usado => usado).length;

        this.setHTML("resumoPontuacoes", `
          <div style="display: flex; justify-content: space-around; margin: 20px 0;">
            <div style="text-align: center; padding: 20px; background-color: white; border-radius: 8px; border: 2px solid #007bff;">
              <h3 style="color: #007bff; margin: 0;">${this.equipes.equipe1.nome}</h3>
              <p style="font-size: 24px; font-weight: bold; margin: 10px 0;">${this.pontuacaoEquipe1} pontos</p>
              <p style="font-size: 14px; color: #666; margin: 5px 0;">Power-ups usados: ${powerUpsUsadosEquipe1}/3</p>
            </div>
            <div style="text-align: center; padding: 20px; background-color: white; border-radius: 8px; border: 2px solid #28a745;">
              <h3 style="color: #28a745; margin: 0;">${this.equipes.equipe2.nome}</h3>
              <p style="font-size: 24px; font-weight: bold; margin: 10px 0;">${this.pontuacaoEquipe2} pontos</p>
              <p style="font-size: 14px; color: #666; margin: 5px 0;">Power-ups usados: ${powerUpsUsadosEquipe2}/3</p>
            </div>
          </div>
        `);

        if (this.pontuacaoEquipe1 > this.pontuacaoEquipe2) {
          this.setHTML("equipeVencedora", 
            `<div class="vencedora" style="text-align: center;">🏆 Parabéns ${this.equipes.equipe1.nome}! Vocês venceram! 🎉</div>`);
        } else if (this.pontuacaoEquipe2 > this.pontuacaoEquipe1) {
          this.setHTML("equipeVencedora", 
            `<div class="vencedora" style="text-align: center;">🏆 Parabéns ${this.equipes.equipe2.nome}! Vocês venceram! 🎉</div>`);
        } else {
          this.setHTML("equipeVencedora", 
            `<div style="text-align: center; font-size: 1.2em; font-weight: bold;">🤝 Empate! Ambas as equipes jogaram muito bem!</div>`);
        }
      },

      // Inicialização
      init: function() {
        // Event listeners
        const nomeInput = this.getElement("nomeJogador");
        if (nomeInput) {
          nomeInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
              e.preventDefault();
              this.adicionarJogador();
            }
          });
          nomeInput.focus();
        }
        
        const nomeEquipe1 = this.getElement("nomeEquipe1");
        const nomeEquipe2 = this.getElement("nomeEquipe2");
        
        if (nomeEquipe1) {
          nomeEquipe1.addEventListener("input", () => this.atualizarEquipes());
        }
        if (nomeEquipe2) {
          nomeEquipe2.addEventListener("input", () => this.atualizarEquipes());
        }
        
        this.atualizarListaJogadores();
      }
    };

    // Inicializar quando o DOM estiver carregado
    document.addEventListener('DOMContentLoaded', function() {
      jogo.init();
    });
    </script>
</body>
</html>