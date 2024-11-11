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
function decryptPassword($encryptedPassword) {
    $encryptedPassword = base64_decode($encryptedPassword);
    $ivLength = openssl_cipher_iv_length(ENCRYPTION_METHOD);
    $iv = substr($encryptedPassword, 0, $ivLength); 
    $encryptedPassword = substr($encryptedPassword, $ivLength); 
    return openssl_decrypt($encryptedPassword, ENCRYPTION_METHOD, ENCRYPTION_KEY, 0, $iv);
}

function showPassword($password_id,$pdo){
    $stmt = $pdo->prepare('SELECT app_password FROM generator WHERE id=:password_id AND user_id= :user_id ');
    $stmt->execute([
        ':password_id' => $password_id,
        ':user_id' => $_SESSION['user_id']
        ]);
    $encryptedPassword = $stmt->fetchColumn();
    if ($encryptedPassword) {
        $originalPassword = decryptPassword($encryptedPassword);
        return $originalPassword;
    } else {
        return 'false';
    }

}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password_id']) && isset($_POST['code'])) {

    $verifiedCode=verifyCode($_POST['code'],$pdo);
}
