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
// verify length
function verifyLength($length){
    var_dump($length);
    if(empty($length)){
        $errorMessage = "Length Empty";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
    if($length!=='small_characters'&& $length!=='large_characters'){
        $errorMessage = "Values of Length Changed";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }

    switch ($length) {
        case 'small_characters':

            $verifiedLength=12;

            return $verifiedLength;

          break;
        case 'large_characters':

            $verifiedLength=32;

            return $verifiedLength;
            
          break;
      
      }

}
// function for password Generate!

function generatePassword($hasLength,$hasSymbols,$sizeType){
    
    $generatedPassword;
    $numbers='1234567890';
    $symbols = '! " # $ % & \' ( ) * + , - . / : ; < = > ? @ [ \\ ] ^ _ ` { | } ~';
    $smalLength=12;
    $LargeLength=32;

}

$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // app date
    $name=$_POST['name'];
    $email=$_POST['email'];

    if(empty($name) || empty($email)){
        $errorMessage = "Name or email empty";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }

    // password type
    $length=verifyLength($_POST['Length']);
    $numbers =$_POST['numbers'] ?? 'false';
    $symbols =$_POST['Symbols'] ?? 'false';


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


    echo htmlspecialchars("$name,$email,$numbers,$symbols,$length");

}