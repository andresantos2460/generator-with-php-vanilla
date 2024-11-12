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

function verifyCode($code,$pdo){
    $stmt = $pdo->prepare("SELECT code FROM user WHERE id = :user_id");
    $stmt->execute([
    ':user_id' => $_SESSION['user_id']
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $codeFromDB = $result['code'];

    if($codeFromDB!=$code){
        $errorMessage = "Wrong Code!";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }else{
        $verifiedCode='true';
    } 
    
    return $verifiedCode;
}

    function deletePassword($id,$pdo){
        $stmt = $pdo->prepare("DELETE  FROM generator WHERE id = :id AND user_id=:user_id");
        $stmt->execute([
        ':id' => $id,
        ':user_id' => $_SESSION['user_id'],
        ]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['code'])) {
    if($_POST['token']!=$_SESSION['csrf_token']){
        $errorMessage = "os tokens nao combinam";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
    $password_id = $_POST['product_id'];
    $code=verifyCode($_POST['code'],$pdo);
    $result=deletePassword($password_id, $pdo);
    if($result) {
        $successMessage = "Password Deleted !";
        header("Location: index.php?success=" . urlencode($successMessage));
        exit();
    }else{
        $errorMessage = "Error Deleting the Password";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }
   
   
}