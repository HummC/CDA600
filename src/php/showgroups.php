<?php
session_start();
session_regenerate_id();
header('content-type: application/json');
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    $user_id = $_SESSION['user_id'];
    require('connect.php');
    
    if(isset($_GET['mygroups'])) {
       $sql = "SELECT * FROM groups WHERE ownerID=:userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
       if(!$row) {
                echo "You have no group goals found!";
                header("HTTP/1.1 404 Not Found");
            }
            else { 
                echo json_encode($row);
                header("HTTP/1.1 200 OK");
                
            }
    }
    else {
    $query = $conn->query("SELECT ID, name, category, start_date, end_date, description, importance, difficulty, status, taskNo, size, members FROM groups");
    $result=$query->fetchAll(PDO::FETCH_ASSOC);
    if(!$result) {
        echo "No groups exist";
        header("HTTP/1.1 404 Not Found");
    }
    else {
        echo json_encode($result);
        header("HTTP/1.1 200 OK");
    }
    }
}

?>