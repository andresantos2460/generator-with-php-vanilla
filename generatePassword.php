<?php
require 'db_connection.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit(); 
}
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
}
// verify length
function verifyLength($length){
    if(empty($length)){
        $errorMessage = "Length Empty";
        header("Location: /index?error=" . urlencode($errorMessage));
        exit();
    }
    if($length!=='small_characters'&& $length!=='large_characters'){
        $errorMessage = "Values of Length Changed";
        header("Location: /index?error=" . urlencode($errorMessage));
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

// verify CheckBoxex
function verifyCheckBox($input){
    if(empty($input)){
       $verifiedInput='false';
    }else{
       $verifiedInput='true';
    }
    return $verifiedInput;
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
    // verigy token
    if($_POST['token']!=$_SESSION['csrf_token']){
        $errorMessage = "os tokens nao combinam";
        header("Location: /index?error=" . urlencode($errorMessage));
        exit();
    }

    // app date
    $name=$_POST['name'];
    $email=$_POST['email'];

    if(empty($name) || empty($email)){
        $errorMessage = "Name or email empty";
        header("Location: /index?error=" . urlencode($errorMessage));
        exit();
    }

    // password type
    $length=verifyLength($_POST['Length']);
    $numbers = verifyCheckBox(isset($_POST['numbers']) ? $_POST['numbers'] : null);
    $symbols = verifyCheckBox(isset($_POST['Symbols']) ? $_POST['Symbols'] : null);
   


    echo htmlspecialchars("$name,$email,$numbers,$symbols,$length");

}