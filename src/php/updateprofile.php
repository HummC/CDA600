<?php
session_start();
session_regenerate_id();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}
else {
    
    // READING IN INPUT
    $bio = htmlspecialchars($_POST['bio']);
    $name = htmlspecialchars($_POST['name']);
    
    if(isset($_POST['name']) XOR isset($_POST['bio'])) {
        if(isset($_POST['name']) && !empty($_POST['name'])) {
            $sql = "UPDATE users SET name =:name WHERE ID=:userid";
        }
        
        else {
            $sql = "UPDATE users SET bio =:bio WHERE ID=:userid";
        }
    }
    else if(isset($_POST['name']) && isset($_POST['bio'])) {
        // IF BOTH ARE NOT EMPTY COMBINED STATEMENT
        if(!empty($_POST['name']) && !empty($_POST['bio'])) {
           $sql = "UPDATE users SET name =:name, bio = :bio WHERE ID=:userid";
        }
        // IF NAME IS EMPTY BUT BIO IS NOT UPDATE BIO
        else if(empty($_POST['name']) && !empty($_POST['bio'])) {
            $sql = "UPDATE users SET bio =:bio WHERE ID=:userid";
        }
        // IF BIO IS EMPTY BUT NAME IS NOT UPDATE NAME
        else if(!empty($_POST['name']) && empty($_POST['bio'])) {
            $sql = "UPDATE users SET name =:name WHERE ID=:userid";
        }
        // BOTH ARE EMPTY
        else {
            header("HTTP/1.1 404 Not Found");
            die();
        }
    }
    
    else {
        // NEITHER FIELD IS SET
        header("HTTP/1.1 404 Not Found");
        die();
    }
    $user_id = $_SESSION['user_id'];
    require('connect.php');
    $statement = $conn->prepare($sql);
    $statement->execute(
           array(':userid'=>$user_id,
                 ':name'=>$name,
                 ':bio'=>$bio
                ));
    header("HTTP/1.1 200 OK");
}
?>