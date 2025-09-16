// resultado.js
window.addEventListener("load", ()=>{
  const dataStr = sessionStorage.getItem("cacaPalavrasResult");
  const foundStr = sessionStorage.getItem("cacaPalavrasFound");
  const div = document.getElementById("resultInfo");
  if(!dataStr){ div.textContent = "Nenhum resultado disponível."; return; }
  const data = JSON.parse(dataStr);
  const found = foundStr ? JSON.parse(foundStr) : [];
  let html = `
    <p><strong>Tempo usado:</strong> ${data.timeUsed}</p>
    <p><strong>Pontos:</strong> ${data.points}</p>
    <p><strong>Palavras encontradas:</strong> ${found.length} / ${data.totalWords}</p>
    <h3>Palavras encontradas:</h3>
    <ul>
  `;
  for(const w of found) html += `<li style="color:#9b59b6;font-weight:700">${w}</li>`;
  html += `</ul><div style="margin-top:12px"><button id="backBtn" style="background:#9b59b6;color:#000;padding:10px 14px;border-radius:6px;">Voltar</button></div>`;
  div.innerHTML = html;
  document.getElementById("backBtn").addEventListener("click", ()=>{
    // limpa sessão para nova tentativa
    sessionStorage.removeItem("cacaPalavrasResult");
    sessionStorage.removeItem("cacaPalavrasFound");
    window.location.href = "responder.html";
  });
});
