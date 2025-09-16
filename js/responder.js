// responder.js
const modal = document.getElementById("modalMessage");
const modalText = document.getElementById("modalText");
function showModal(msg){ modalText.textContent = msg; modal.style.display = "flex"; }
function closeModal(){ modal.style.display = "none"; }

const fileInput = document.getElementById("jsonInput");
const startBtn = document.getElementById("startBtn");
const btnPause = document.getElementById("btnPause");
const btnUnlimited = document.getElementById("btnUnlimited");
const btnHelp = document.getElementById("btnHelp");
const btnRestart = document.getElementById("btnRestart");
const timerDiv = document.getElementById("timer");
const boardDiv = document.getElementById("board");
const descList = document.getElementById("descriptionList");
const resultDiv = document.getElementById("result");
const messageHelp = document.getElementById("messageHelp");

let loadedActivity = null;
let boardData = [];
let wordsData = [];
let size = 15;

let isSelecting = false;
let selectedCells = [];
let startPos = null;

let timer = null;
let timeLeft = 210;
let pauseCount = 3;
let isPaused = false;
let unlimitedTime = false;

let foundWordsSet = new Set();

fileInput.addEventListener("change", (e)=>{
  const f = e.target.files[0];
  if(!f) return;
  const reader = new FileReader();
  reader.onload = ev=>{
    try{
      const data = JSON.parse(ev.target.result);
      if(!data.size || !data.wordsData || !data.boardData) { showModal("JSON inválido"); return; }
      loadedActivity = data; showModal("Atividade carregada. Clique em Iniciar Atividade.");
    }catch{
      showModal("Erro lendo o arquivo JSON.");
    }
  };
  reader.readAsText(f);
});

startBtn.addEventListener("click", startGame);
btnPause.addEventListener("click", togglePause);
btnUnlimited.addEventListener("click", enableUnlimited);
btnHelp.addEventListener("click", ()=>{ messageHelp.style.display = messageHelp.style.display === "none" ? "block" : "none"; });
btnRestart.addEventListener("click", restartGame);

function startGame(){
  if(!loadedActivity){ showModal("Importe o JSON primeiro."); return; }
  boardData = loadedActivity.boardData;
  wordsData = loadedActivity.wordsData;
  size = loadedActivity.size || 15;
  foundWordsSet = new Set();
  timeLeft = 210; pauseCount = 3; isPaused = false; unlimitedTime = false;
  btnPause.textContent = `Pause (${pauseCount})`; btnPause.disabled = false; btnUnlimited.disabled = false;
  fileInput.disabled = true; resultDiv.textContent = "";
  renderDescriptions(); renderBoard(); startTimer();
}

function restartGame(){
  clearInterval(timer);
  fileInput.disabled = false; loadedActivity = null; boardData = []; wordsData = []; size = 15;
  boardDiv.innerHTML = ""; descList.innerHTML = ""; resultDiv.textContent = "";
  timeLeft = 210; pauseCount = 3; isPaused = false; unlimitedTime = false;
  timerDiv.textContent = `Tempo: 03:30`; showModal("Atividade reiniciada. Importe JSON e inicie.");
  sessionStorage.removeItem("cacaPalavrasFound"); sessionStorage.removeItem("cacaPalavrasResult");
}

function renderDescriptions(){
  descList.innerHTML = "";
  wordsData.forEach(item=>{
    const li = document.createElement("li");
    li.textContent = item.description;
    descList.appendChild(li);
  });
}

function renderBoard(){
  boardDiv.innerHTML = ""; boardDiv.style.gridTemplateColumns = `repeat(${size}, 34px)`;
  for(let r=0;r<size;r++){
    for(let c=0;c<size;c++){
      const cell = document.createElement("div");
      cell.className = "cell"; cell.textContent = boardData[r][c];
      cell.dataset.row = r; cell.dataset.col = c;
      cell.addEventListener("mousedown", startSelection);
      cell.addEventListener("mouseover", extendSelection);
      cell.addEventListener("mouseup", endSelection);
      boardDiv.appendChild(cell);
    }
  }
}

/* selection */
function startSelection(e){
  if(isPaused) return;
  isSelecting = true; selectedCells = [];
  startPos = { row: parseInt(e.target.dataset.row), col: parseInt(e.target.dataset.col) };
  document.querySelectorAll(".cell").forEach(c=>c.classList.remove("selected"));
  selectCell(e.target);
}
function extendSelection(e){
  if(!isSelecting || isPaused) return;
  const endRow = parseInt(e.target.dataset.row), endCol = parseInt(e.target.dataset.col);
  const rowDiff = endRow - startPos.row, colDiff = endCol - startPos.col;
  if(rowDiff === 0 || colDiff === 0 || Math.abs(rowDiff) === Math.abs(colDiff)){
    document.querySelectorAll(".cell").forEach(c=>c.classList.remove("selected"));
    selectedCells = [];
    const steps = Math.max(Math.abs(rowDiff), Math.abs(colDiff));
    const stepRow = rowDiff === 0 ? 0 : rowDiff / steps;
    const stepCol = colDiff === 0 ? 0 : colDiff / steps;
    for(let i=0;i<=steps;i++){
      const r = startPos.row + stepRow*i, c = startPos.col + stepCol*i;
      const cell = document.querySelector(`.cell[data-row='${r}'][data-col='${c}']`);
      if(cell){ cell.classList.add("selected"); selectedCells.push(cell); }
    }
  }
}
function endSelection(){
  if(!isSelecting || isPaused) return;
  isSelecting = false; checkWord();
}
function selectCell(cell){ if(!selectedCells.includes(cell)){ cell.classList.add("selected"); selectedCells.push(cell); } }

/* check word */
function checkWord(){
  const word = selectedCells.map(c=>c.textContent).join("");
  const rev = selectedCells.map(c=>c.textContent).reverse().join("");
  const foundObj = wordsData.find(w=> w.word === word || w.word === rev);
  if(foundObj && !foundWordsSet.has(foundObj.word)){
    selectedCells.forEach(c=> c.classList.add("found"));
    markDescription(foundObj.word); foundWordsSet.add(foundObj.word); saveFoundWords();
  }
  document.querySelectorAll(".cell").forEach(c=>c.classList.remove("selected"));
  selectedCells = [];
  if(foundWordsSet.size === wordsData.length){
    stopTimer();
    const totalUsed = unlimitedTime ? null : 210 - timeLeft;
    const points = calculatePoints(totalUsed, unlimitedTime);
    saveResult(totalUsed, points);
    setTimeout(()=> window.location.href = "resultado.html", 700);
  }
}
function markDescription(word){
  document.querySelectorAll("#descriptionList li").forEach((li, idx)=>{
    if(wordsData[idx].word === word) li.classList.add("found");
  });
}

/* timer */
function startTimer(){
  if(unlimitedTime){ timerDiv.textContent = `Tempo: ∞`; return; }
  timerDiv.textContent = `Tempo: ${formatTime(timeLeft)}`;
  timer = setInterval(()=>{ if(!isPaused){ timeLeft--; timerDiv.textContent = `Tempo: ${formatTime(timeLeft)}`; } if(timeLeft<=0){ clearInterval(timer); showModal("Tempo esgotado!"); disableGame(); saveResult(210,0); setTimeout(()=> window.location.href="resultado.html",800); } },1000);
}
function stopTimer(){ clearInterval(timer); }
function togglePause(){
  if(unlimitedTime) return;
  if(pauseCount === 0){ showModal("Você não tem mais pausas!"); return; }
  isPaused = !isPaused;
  if(isPaused){ pauseCount--; btnPause.textContent = `Continuar (Pausas restantes: ${pauseCount})`; } else btnPause.textContent = `Pause (${pauseCount})`;
}
function enableUnlimited(){
  // keep modal confirmation native minimal
  if(!confirm("Ativar tempo ilimitado? O cronômetro será desativado.")) return;
  unlimitedTime = true; isPaused = false; stopTimer(); timerDiv.textContent = `Tempo: ∞`; btnPause.disabled = true; btnUnlimited.disabled = true;
}
function formatTime(s){ const m=Math.floor(s/60), sec=s%60; return `${m.toString().padStart(2,"0")}:${sec.toString().padStart(2,"0")}`; }
function disableGame(){ document.querySelectorAll(".cell").forEach(c=> c.style.pointerEvents="none"); btnPause.disabled=true; btnUnlimited.disabled=true; fileInput.disabled=true; }

/* scoring & saving */
function calculatePoints(timeUsed, unlimited){
  if(unlimited) return 25;
  if(timeUsed <= 105) return 100;
  if(timeUsed > 210) return 0;
  const t = timeUsed - 105;
  return Math.round(100 - ((t/105) * 50));
}
function saveResult(timeUsed, points){
  const data = { timeUsed: timeUsed===null ? 'Ilimitado' : formatTime(timeUsed), points, totalWords: wordsData.length, foundWords: Array.from(foundWordsSet) };
  sessionStorage.setItem("cacaPalavrasResult", JSON.stringify(data));
}
function saveFoundWords(){ sessionStorage.setItem("cacaPalavrasFound", JSON.stringify(Array.from(foundWordsSet))); }
