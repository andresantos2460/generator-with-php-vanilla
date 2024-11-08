<?php
session_start();
require 'db_connection.php';
if (isset($_SESSION["user_id"])){
    header('location:index.php');
    exit();
}
/* login process */
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT id, name, password FROM user WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
     
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['name'] = $user['name'];  

                $successMessage = "Login bem-sucedido! Redirecionando...";
                header('refresh:1; url=index.php');  
                exit();  
            } else {
                $errorMessage = "Senha incorreta.";
            }
        } else {
            $errorMessage = "Usuário não encontrado.";
        }
    } else {
        $errorMessage = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Página de Login</title>
</head>

<body>
    <div class="container pt-5">
        <div class="title">
            <h1>Login Account</h1>
        </div>
    <form method="POST">

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" required class="form-control" id="exampleInputPassword1">
  </div>
  <?php
    if (!empty($errorMessage)) {
        echo '<div class="alert alert-danger" role="alert">'. $errorMessage .'</div>';
    }
  ?>
    <?php
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success" role="alert">'.$successMessage .'</div>';
    }
  ?>
  <div class="mb-3">
  <a href="register.php">Criar Conta!</a>

  </div>
  <button type="submit" class="btn btn-primary">Login</button>
</form>
    </div>



</body>
</html>