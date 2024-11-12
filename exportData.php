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

function exportData($pdo)
{
    $userID = $_SESSION['user_id'];

    $stmt = $pdo->prepare('SELECT app_name, app_email, app_password FROM generator WHERE user_id = :user_id');
    $stmt->execute([':user_id' => $userID]);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        $errorMessage = "No Passwords Available to Export!";
        header("Location: index.php?error=" . urlencode($errorMessage));
        exit();
    }

    $fileName = 'passwords_export_' . $userID . '.csv';

    // Set headers for file download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');

    // Open PHP output stream as CSV file
    $output = fopen('php://output', 'w');

    // Write CSV column headers
    fputcsv($output, ['name', 'url', 'username', 'password']);

    // Write each row of data to CSV
    foreach ($results as $row) {
        $decryptedPassword = decryptPassword($row['app_password']);
        fputcsv($output, [
            $row['app_name'],   // name
            '',                 // url (leave empty if not available)
            $row['app_email'],  // username
            $decryptedPassword, // password
        ]);
    }

    // Close output stream
    fclose($output);

    // End the script to ensure only the CSV is sent
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code'])) {

    $verifiedCode=verifyCode($_POST['code'],$pdo);
    exportData($pdo);

}else{
    echo "preenche dados!";
}
