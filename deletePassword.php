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
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // verigy token
    if($_POST['token']!=$_SESSION['csrf_token']){
        $errorMessage = "os tokens nao combinam";
        header("Location: /index?error=" . urlencode($errorMessage));
        exit();
    }
}