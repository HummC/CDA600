<?php
session_start();
session_regenerate_id();
// CHECK THAT USER IS AUTHORISED TO RUN THIS SCRIPT
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}
else {
$user_id = $_SESSION['user_id'];
require('connect.php');
// CHECK WHICH OUT OF GOAL, TASK AND GROUP IS SET   
if(isset($_POST['group_id']) OR isset($_POST['goal_id']) OR isset($_POST['task_id'])) {
    if(isset($_POST['group_id'])) {
        $group_id = $_POST['group_id'];
        if(isset($_POST['complete'])) {
            $status = $_POST['complete'];
            if($status == 1) {
                $status = "complete";
            }
            else {
                $status = "in-complete";
            }
            // UPDATE QUERY FOR GROUP
           $sql = "UPDATE `groups` SET status=:status WHERE ID=:groupid AND ownerID = :userid";
           $statement = $conn->prepare($sql);
           $statement->execute(
           array(':groupid'=>$group_id,
                 ':userid'=>$user_id,
                 ':status'=>$status
                ));
           header("HTTP/1.1 200 OK"); 
           die();
        }
        else {
            // BAD REQUEST
            header("HTTP/1.1 400 Bad request");
            die();
        }
    }
    else if(isset($_POST['goal_id'])) {
        $goal_id = $_POST['goal_id'];
        if(isset($_POST['complete'])) {
            $status = $_POST['complete'];
            if($status == 1) {
                $status = "complete";
            }
            else {
                $status = "in-complete";
            }
            
            // UPDATE QUERY FOR GOAL
           $sql = "UPDATE `goals` SET status=:status WHERE ID=:goalid AND userID=:userid";
           $statement = $conn->prepare($sql);
           $statement->execute(
           array(':goalid'=>$goal_id,
                 ':userid'=>$user_id,
                 ':status'=>$status
                ));
           header("HTTP/1.1 200 OK"); 
           die();
        }
        else {
            // BAD REQUEST
            header("HTTP/1.1 400 Bad request");
            die();
        }
    }
    else if(isset($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        if(isset($_POST['complete'])) {
            $status = $_POST['complete'];
            if($status == 1) {
                $status = "complete";
            }
            else {
                $status = "in-complete";
            }
            // UPDATE QUERY FOR GOAL
            $sql = "UPDATE `tasks` SET status=:status WHERE ID=:taskid AND userID=:userid";
           $statement = $conn->prepare($sql);
           $statement->execute(
           array(':taskid'=>$task_id,
                 ':userid'=>$user_id,
                 ':status'=>$status
                ));
           header("HTTP/1.1 200 OK");
           die();
        }
        else {
            // BAD REQUEST
            header("HTTP/1.1 400 Bad request");
            die();
        }
        
    }
    else {
        // INVALID REQUEST
       
    }
}   
    
}



