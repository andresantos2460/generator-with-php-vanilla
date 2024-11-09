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

const target = document.getElementById('kt_clipboard_1');
const button = target.nextElementSibling;

var clipboard = new ClipboardJS(button, {
    target: target,
    text: function() {
        return target.value;
    }
});

clipboard.on('success', function(e) {
    const currentLabel = button.innerHTML;

    if(button.innerHTML === 'Copied!'){
        return;
    }

    button.innerHTML = 'Copied!';

    setTimeout(function(){
        button.innerHTML = currentLabel;
    }, 3000)
});