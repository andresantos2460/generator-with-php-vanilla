<?php
require 'db_connection.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit(); 
}


?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
</head>
<body>
    <div class="container pt-5">
      <?php
      if (isset($_SESSION['user_code'])) {
        echo ' <div style="background-color: #edfbd8 !important; position:relative;" class="alert alert-success" id="alert-modal" role="alert">
                <svg style="position:absolute; top:15px; right:15px;" xmlns="http://www.w3.org/2000/svg" width="22" height="22" id="close-button" fill="#2b641e" class="bi bi-x" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg>
            <h4 style="color: #2b641e;" class="alert-heading">Código:<b class="ms-2" id="myInput" data-code='.$_SESSION['user_code'].'>'.$_SESSION['user_code'].'</b></h4>
            <p>Vais Precisar deste código sempre que pretenderes visualizar e eliminar uma password!</p>
            <hr />
            <div class="">
                <div>
                    <button onclick="myFunction()" class="copy-button">
                        <span>
                            <svg
                                width="12"
                                height="12"
                                fill="#0E418F"
                                xmlns="http://www.w3.org/2000/svg"
                                shape-rendering="geometricPrecision"
                                text-rendering="geometricPrecision"
                                image-rendering="optimizeQuality"
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                viewBox="0 0 467 512.22"
                            >
                                <path
                                    fill-rule="nonzero"
                                    d="M131.07 372.11c.37 1 .57 2.08.57 3.2 0 1.13-.2 2.21-.57 3.21v75.91c0 10.74 4.41 20.53 11.5 27.62s16.87 11.49 27.62 11.49h239.02c10.75 0 20.53-4.4 27.62-11.49s11.49-16.88 11.49-27.62V152.42c0-10.55-4.21-20.15-11.02-27.18l-.47-.43c-7.09-7.09-16.87-11.5-27.62-11.5H170.19c-10.75 0-20.53 4.41-27.62 11.5s-11.5 16.87-11.5 27.61v219.69zm-18.67 12.54H57.23c-15.82 0-30.1-6.58-40.45-17.11C6.41 356.97 0 342.4 0 326.52V57.79c0-15.86 6.5-30.3 16.97-40.78l.04-.04C27.51 6.49 41.94 0 57.79 0h243.63c15.87 0 30.3 6.51 40.77 16.98l.03.03c10.48 10.48 16.99 24.93 16.99 40.78v36.85h50c15.9 0 30.36 6.5 40.82 16.96l.54.58c10.15 10.44 16.43 24.66 16.43 40.24v302.01c0 15.9-6.5 30.36-16.96 40.82-10.47 10.47-24.93 16.97-40.83 16.97H170.19c-15.9 0-30.35-6.5-40.82-16.97-10.47-10.46-16.97-24.92-16.97-40.82v-69.78zM340.54 94.64V57.79c0-10.74-4.41-20.53-11.5-27.63-7.09-7.08-16.86-11.48-27.62-11.48H57.79c-10.78 0-20.56 4.38-27.62 11.45l-.04.04c-7.06 7.06-11.45 16.84-11.45 27.62v268.73c0 10.86 4.34 20.79 11.38 27.97 6.95 7.07 16.54 11.49 27.17 11.49h55.17V152.42c0-15.9 6.5-30.35 16.97-40.82 10.47-10.47 24.92-16.96 40.82-16.96h170.35z"
                                ></path>
                            </svg>
                            Copiar
                        </span>
                        <span>Copiado</span>
                    </button>
                    <div></div>
                </div>
            </div>
        </div>';
        unset($_SESSION['user_code']);
    }
      ?>
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Nome da</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" />
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
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
</script>
</html>
