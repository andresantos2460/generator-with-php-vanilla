<?php
require 'db_connection.php';

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

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $length=$_POST['Length'];
    if(empty($_POST['numbers'])){
        $numbers='false';
    }
    if(empty($_POST['Symbols'])){
        $symbols='false';
    }
    if(empty($name) || empty($email)){
        $errorMessage = "Name or email empty";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
    if(empty($_POST['Length'])){
        $errorMessage = "Length empty";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
   
 

    if($_POST['token']!=$_SESSION['csrf_token']){
        $errorMessage = "os tokens nao combinam";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
    if(empty($name)&& empty($email)){
        $errorMessage = "Name or email empty";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }


    echo htmlspecialchars("$name,$email,$numbers,$symbols,$length");

}