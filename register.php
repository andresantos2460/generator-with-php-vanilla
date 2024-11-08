<?php
require 'db_connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}
/* function generate code */
function codeCreate($pdo) {
    do {
        $code = rand(1000, 9999);

        $stmt = $pdo->prepare("SELECT id FROM user WHERE code = :codigo LIMIT 1");
        $stmt->bindParam(':codigo', $code);
        $stmt->execute();
        
        $codeUnic = ($stmt->rowCount() == 0);
        
    } while (!$codeUnic); 
    
    return $code;
}

function verifyEmail($pdo,$email){
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}

/* register proces */
$errorMessage = "";
$successMessage = "";
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['password_confirm'];
    $code = codeCreate($pdo);

    if (!empty($email) && !empty($password)&& !empty($name) && !empty($confirm_password)) {
        $emailUnic=verifyEmail($pdo,$email);

     
        if($confirm_password != $password) {
            $errorMessage = "Passwords nao combinam";
            header("Location: register.php?error=" . urlencode($errorMessage));
            exit();

        }else if($emailUnic==false){
            $errorMessage = "Erro, email em uso!";
            header("Location: register.php?error=" . urlencode($errorMessage));
            exit();
        }
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO user (name, email, password, code) VALUES (:name, :email, :password, :code)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':code', $code);

            if ($stmt->execute()) {
                $successMessage = "Criado com Sucesso!";
                $user_id = $pdo->lastInsertId();
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_code'] = $code;
                $_SESSION['name'] = $name;  
                header('refresh:1; url=index.php');  // Aguardar 2 segundos e redirecionar
    
            } else {
                $errorMessage = "Erro ao criar Conta!";
    
            }
        }

    
    } else {
        $errorMessage = "Preencha todos os dados!";

    }
    
    }

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Criar Conta</title>
</head>
<body>
    <div class="container pt-5">
        <div class="title">
            <h1>Create Account</h1>
        </div>
    <form method="POST">
    <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="email" name="name" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" required class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" required class="form-control" id="exampleInputPassword1">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
    <input type="password" name="password_confirm" required class="form-control" id="exampleInputPassword1">
  </div>
  <?php
    if (!empty($errorMessage)) {
        echo '<div class="alert alert-danger" role="alert">'. $errorMessage .'</div>';
    }else if(isset($_GET['error'])){
            echo '<div class="alert alert-danger" role="alert">'. htmlspecialchars($_GET['error']) . '</div>';
        }
    
  ?>
    <?php
    if (!empty($successMessage)) {
        echo '<div class="alert alert-success" role="alert">'. $successMessage .'</div>';
    }
  ?>
  <div class="mb-3">
  <a href="login.php">Login!</a>
  </div>
  <button type="submit" class="btn btn-primary">Create Account</button>
</form>
    </div>



</body>
</html>