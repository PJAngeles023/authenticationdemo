<?php

session_start();
require 'dbconnect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

// Validate if passwords match
if($password != '' && $password == $confirmpassword){

    // Validate if username is already taken
    $sql = "SELECT username FROM users WHERE username = '{$username}';";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $_SESSION['error'] = "Oops! <strong>{$username}</strong> is already taken.";
        header('location: ../register.php');
    }else{
        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password) VALUES ('{$username}', '{$password}');";

        if($conn->query($sql)){
            $_SESSION['success'] = "Account successfully created!";
            header('location: ../index.php');
        }else{
            $_SESSION['error'] = "Oops! Something went wrong :(";
            header('location: ../register.php');
        }
    }

}else{
    $_SESSION['error'] = "Passwords do not match!";
    header('location: ../register.php');
}

?>  