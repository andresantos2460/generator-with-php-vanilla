<?php
require 'db_connection.php';
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit(); 
}
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}


    $errorMessage = "";
    $successMessage = "";

    if(!$_SERVER['REQUEST_METHOD'] == "POST"){
        $errorMessage = "Error Form";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }


    function encryptPassword($password) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(ENCRYPTION_METHOD)); // Gera um IV seguro
        $encryptedPassword = openssl_encrypt($password, ENCRYPTION_METHOD, ENCRYPTION_KEY, 0, $iv);
        return base64_encode($iv . $encryptedPassword); // Armazena o IV junto com o texto criptografado
    }


    // verigy token
    if($_POST['token']!=$_SESSION['csrf_token']){
        $errorMessage = "os tokens nao combinam";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['new_password'];

    if(empty($password)){
        $errorMessage ='New Password Empty';
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }

    if(empty($name) || empty($email)){
        $errorMessage = "Name or email  empty";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }


    $hashedPassword = encryptPassword($password);
    $stmt = $pdo->prepare("INSERT INTO generator (user_id, app_name,app_email, app_password) VALUES (:user_id, :appName,:appEmail, :password)");

    $stmt->execute([
        ':user_id' => $_SESSION['user_id'],          
        ':appName' => $name,       
        ':appEmail' => $email,      
        ':password' => $hashedPassword  
    ]);
    $successMessage="Sucesso!";
    header("Location: index.php?success=" . urlencode($successMessage));
    
    exit();