<?php
require 'db_connection.php';
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
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
        header("Location: /index?error=" . urlencode($errorMessage));
        exit();
    }else{
        $verifiedCode='true';
    } 
    
    return $verifiedCode;
}
