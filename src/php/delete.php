<?php
session_start();
session_regenerate_id();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    $user_id = $_SESSION['user_id'];
    require('connect.php');
    
    
    // DELETING GOALS
if(isset($_POST['goal_id'])) {
       $goal_id = $_POST['goal_id'];
       $sql = "DELETE FROM goals WHERE userID=:userid AND ID=:goalid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':goalid'=>$goal_id
                ));
    header("HTTP/1.1 200 OK");
}
    // DELETING GROUPS
    else if(isset($_POST['group_id'])) {
       $group_id = $_POST['group_id'];
       $sql = "DELETE FROM groups WHERE ownerID=:userid AND ID=:groupid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':groupid'=>$group_id
                ));
        header("HTTP/1.1 200 OK");
    }
    
    // DELETING TASKS
    else if(isset($_POST['task_id'])) {
       $group_id = $_POST['task_id'];
       $sql = "DELETE FROM tasks WHERE userID=:userid AND ID=:taskid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':taskid'=>$task_id
                ));
        header("HTTP/1.1 200 OK");
    }
    // NOTHING TO DELETE
    else {
        header("HTTP/1.1 400 Bad request");
        die();
    }
}

?>