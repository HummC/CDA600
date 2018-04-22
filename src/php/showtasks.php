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
        
     if(isset($_GET['task_id'])) {
    // determine if group members
      $sql = "SELECT t.userID, g.groupID, g.userID FROM tasks AS t, usergroup AS g WHERE g.groupID=t.groupID AND g.userID = :userid OR t.userID = :userid";
      $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
    $authorized = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(!$authorized) {
        header("HTTP/1.1 401 Unauthorized!");
        die();
    }
         
    else {
    
    // select the tasks
       $taskid = htmlspecialchars($_GET['task_id']);
       $sql = "SELECT * FROM tasks WHERE ID=:taskid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':taskid'=>$taskid
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
       if(!$row) {
                echo "You have no tasks!";
                header("HTTP/1.1 404 Not Found");
                die();
            }
            else { 
                echo json_encode($row);
                header("HTTP/1.1 200 OK");
                
            }
        
    }
     
    }
    
    else {
       $sql = "SELECT * FROM tasks WHERE userID=:userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
       if(!$row) {
                echo "You have no tasks";
                header("HTTP/1.1 404 Not Found");
                die();
            }
            else { 
                echo json_encode($row);
                header("HTTP/1.1 200 OK");
                
            }
    }
}

?>