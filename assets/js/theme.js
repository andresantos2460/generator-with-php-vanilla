var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
$(document).ready(function(){
    $("#close-button").click(function(){
    $("#alert-modal").hide();
  });
});
function myFunction() {
  let div = document.getElementById('myInput');
  let value = div.getAttribute('data-code');
  
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(value).then(() => {
    }).catch(err => {
      console.error('Failed to copy text: ', err);
    });
  } else {
    let tempInput = document.createElement("input");
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); 
    document.execCommand("copy");
    document.body.removeChild(tempInput);
  }
}
document.addEventListener('DOMContentLoaded', () => {
  // Seleciona todos os botões de copiar
  const rows = document.querySelectorAll('.item-row');

  rows.forEach(row => {
      // Obtém o botão de cópia e o campo de senha para esta linha
      const button = row.querySelector('.copy-btn');
      const target = row.querySelector('.password-field');

      // Configura o Clipboard.js para esta linha específica
      const clipboard = new ClipboardJS(button, {
          target: () => target, // Define o campo de entrada de senha como alvo do Clipboard.js
      });

      // Evento de sucesso na cópia
      clipboard.on('success', () => {
          const originalText = button.innerHTML;
          
          // Muda o texto do botão para "Copied!"
          button.innerHTML = 'Copied!';
          
          // Restaura o texto após 3 segundos
          setTimeout(() => {
              button.innerHTML = originalText;
          }, 3000);
      });
  });
});
