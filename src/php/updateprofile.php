<?php
session_start();
session_regenerate_id();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}
else {
    // MAKING CONNECTION TO DATABASE NOW USER IS AUTHENTICATED
    require('connect.php');
    
    
    // READING IN INPUT
    $user_id = $_SESSION['user_id'];
    $bio = htmlspecialchars($_POST['bio']);
    $name = htmlspecialchars($_POST['name']);
    $avatar = $_FILES['avatar'];
    $avatar_name = $_FILES['avatar']['name'];
    echo $avatar_name;
    
    // IF NAME OR BIO IS SELECTED BUT NOT BOTH
    if(isset($_POST['name']) XOR isset($_POST['bio'])) {
        // CHECK IF NAME IS NOT EMPTY RUN SQL TO UPDATE NAME
        if(!empty($_POST['name'])) {
            $sql = "UPDATE users SET name =:name WHERE ID=:userid";
                        $statement = $conn->prepare($sql);
                        $statement->execute(
                        array(':userid'=>$user_id,
                              ':name'=>$name
                ));
             header("HTTP/1.1 200 OK");
            
        }
        // OTHERWISE RUN SQL TO UPDATE BIO, THE ONLY OTHER OPTION.
        else {
                        $sql = "UPDATE users SET bio =:bio WHERE ID=:userid";
                        $statement = $conn->prepare($sql);
                        $statement->execute(
                        array(':userid'=>$user_id,
                              ':bio'=>$bio
                ));
    header("HTTP/1.1 200 OK");
        }
    }
    
    // IF BOTH NAME AND BIO ARE SET - USUALLY THE CASE
    else if(isset($_POST['name']) && isset($_POST['bio'])) {
        // IF BOTH ARE NOT EMPTY RUN SQL WITH BIO AND NAME
        if(!empty($_POST['name']) && !empty($_POST['bio'])) {
           $sql = "UPDATE users SET name =:name, bio = :bio WHERE ID=:userid";
            $statement = $conn->prepare($sql);
                        $statement->execute(
                        array(':userid'=>$user_id,
                              ':bio'=>$bio,
                              ':name'=>$name
                ));
            // LET THE SCRIPT REQUESTING UPDATEPROFILE.PHP KNOW THE UPDATE WAS SUCCESSFUL
             header("HTTP/1.1 200 OK");
        }
        
        // ELSE IF JUST THE NAME
        elseif (!empty($_POST['name']) && empty($_POST['bio'])){
                        
                        echo "name";
                        $sql = "UPDATE users SET name =:name WHERE ID=:userid";
                        $statement = $conn->prepare($sql);
                        $statement->execute(
                        array(':userid'=>$user_id,
                              ':name'=>$name
                ));
             header("HTTP/1.1 200 OK");

        }
        
        elseif (!empty($_POST['bio']) && empty($_POST['name'])) {
                        echo "bio";
                        $sql = "UPDATE users SET bio =:bio WHERE ID=:userid";
                        $statement = $conn->prepare($sql);
                        $statement->execute(
                        array(':userid'=>$user_id,
                              ':bio'=>$bio
                ));
    header("HTTP/1.1 200 OK");
        }
        else {
            die();
        }
    }
    
    else {
        // NEITHER FIELD IS SET
        header("HTTP/1.1 404 Not Found");
        die();
    }
}
?>