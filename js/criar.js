// criar.js
const maxWords = 9;
const ALPHABET = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

const wordsContainer = document.getElementById("wordsContainer");
const addWordBtn = document.getElementById("addWordBtn");
const modal = document.getElementById("modalMessage");
const modalText = document.getElementById("modalText");
const messageDiv = document.getElementById("message");

function showModal(msg){
  modalText.textContent = msg;
  modal.style.display = "flex";
}
function closeModal(){ modal.style.display = "none"; }

function createWordEntry(index){
  const div = document.createElement("div");
  div.className = "wordEntry";
  div.innerHTML = `
    <label>Palavra ${index+1} (apenas letras; máx 12):</label>
    <input type="text" maxlength="20" class="wordInput" />
    <label>Descrição ${index+1}:</label>
    <textarea class="descInput" rows="2"></textarea>
  `;
  return div;
}

function addWord(){
  const current = wordsContainer.children.length;
  if(current >= maxWords){ showModal("Limite máximo de 9 palavras atingido."); return; }
  wordsContainer.appendChild(createWordEntry(current));
  if(wordsContainer.children.length >= maxWords) addWordBtn.disabled = true;
}

addWordBtn.addEventListener("click", addWord);
// start with 3 entries
for(let i=0;i<3;i++) addWord();

document.getElementById("createForm").addEventListener("submit", (e)=>{
  e.preventDefault();
  const wordEls = document.querySelectorAll(".wordInput");
  const descEls = document.querySelectorAll(".descInput");
  const wordsData = [];

  for(let i=0;i<wordEls.length;i++){
    const raw = wordEls[i].value.trim();
    const desc = descEls[i].value.trim();
    if(!raw || !desc){ showModal("Preencha todas as palavras e descrições."); return; }
    const w = sanitize(raw);
    if(w.length < 3){ showModal(`Palavra ${i+1} (“${raw}”) ficou com menos de 3 letras após limpeza.`); return; }
    if(w.length > 12){ showModal(`Palavra ${i+1} (“${raw}”) tem mais de 12 letras após limpeza.`); return; }
    wordsData.push({ word: w, description: desc });
  }

  const size = 15;
  const result = generateBoardBacktracking(size, wordsData);
  if(!result.success){ showModal("Não foi possível posicionar todas as palavras. Reduza/alterar palavras."); return; }

  const activity = { size, wordsData, boardData: result.board };
  downloadJSON(JSON.stringify(activity, null, 2), "atividade_caca_palavras.json");
  showModal("JSON gerado e baixado com sucesso!");
});

function downloadJSON(text, filename){
  const blob = new Blob([text], {type:"application/json"});
  const a = document.createElement("a");
  a.href = URL.createObjectURL(blob);
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  a.remove();
  URL.revokeObjectURL(a.href);
}
function sanitize(s){
  return s.toUpperCase().normalize('NFD').replace(/[\u0300-\u036f]/g,'').replace(/[^A-Z]/g,'');
}

/* BACKTRACKING GENERATOR */
function generateBoardBacktracking(size, wordsData){
  const words = [...wordsData].sort((a,b)=> b.word.length - a.word.length).map(x=>x.word);
  const board = Array.from({length:size}, ()=> Array(size).fill(""));
  const usage = Array.from({length:size}, ()=> Array(size).fill(0));
  const directions = [[1,0],[-1,0],[0,1],[0,-1],[1,1],[-1,-1],[-1,1],[1,-1]];

  function shuffle(arr){
    for(let i=arr.length-1;i>0;i--){
      const j = Math.floor(Math.random()*(i+1)); [arr[i],arr[j]]=[arr[j],arr[i]];
    }
    return arr;
  }
  function allCells(n){ const out=[]; for(let r=0;r<n;r++) for(let c=0;c<n;c++) out.push([r,c]); return out; }

  function canPlace(word,row,col,dx,dy){
    const n = word.length;
    const endR = row + dy*(n-1), endC = col + dx*(n-1);
    if(endR < 0 || endR >= size || endC < 0 || endC >= size) return false;
    for(let i=0;i<n;i++){
      const r = row + dy*i, c = col + dx*i;
      if(board[r][c] !== "" && board[r][c] !== word[i]) return false;
    }
    return true;
  }
  function placeWord(word,row,col,dx,dy){
    const coords=[];
    for(let i=0;i<word.length;i++){
      const r = row + dy*i, c = col + dx*i;
      if(board[r][c] === "") board[r][c] = word[i];
      usage[r][c] += 1;
      coords.push([r,c]);
    }
    return coords;
  }
  function removeWord(coords){
    for(const [r,c] of coords){ usage[r][c] -= 1; if(usage[r][c] === 0) board[r][c] = ""; }
  }

  function solve(idx){
    if(idx === words.length) return true;
    const W = words[idx];
    const dirs = shuffle(directions.slice());
    const cells = shuffle(allCells(size));
    for(const [dx,dy] of dirs){
      for(const [r,c] of cells){
        if(canPlace(W,r,c,dx,dy)){
          const coords = placeWord(W,r,c,dx,dy);
          if(solve(idx+1)) return true;
          removeWord(coords);
        }
      }
    }
    return false;
  }

  const ok = solve(0);
  if(!ok) return { success:false };
  for(let r=0;r<size;r++) for(let c=0;c<size;c++) if(board[r][c]==="") board[r][c] = ALPHABET[Math.floor(Math.random()*ALPHABET.length)];
  return { success:true, board };
}
