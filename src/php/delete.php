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
    
    
    // DELETING GOALS + TASKS FOR THAT GOAL
if(isset($_POST['goal_id'])) {
       $goal_id = $_POST['goal_id'];
       $sql = "DELETE FROM goals WHERE userID=:userid AND ID=:goalid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':goalid'=>$goal_id
                ));
        $count = $statement->rowCount();
            
        if($count > 0) {
           $sql = "DELETE FROM tasks WHERE userID = :userid AND goalID=:goalid";
           $statement = $conn->prepare($sql);
           $statement->execute(
           array(':userid'=>$user_id,
                 ':goalid'=>$goal_id
                ));
        
           print("Deleted $count rows.\n"); 
           header("HTTP/1.1 200 OK");
        }
    
    else {
        header("HTTP/1.1 400 Bad request");
        die();
        
    }
        
        // THEN DELETE THE TASKS
          
        
}
    // DELETING GROUPS + TASKS FOR THAT GROUP
    else if(isset($_POST['group_id'])) {
       $group_id = $_POST['group_id'];
       
        // DELETE THE MEMBERS OF THE GROUP FIRST - FOREIGN KEY CONSTRAINT
       $sql = "DELETE FROM usergroup WHERE groupID=:groupid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(
                 ':groupid'=>$group_id
                ));
        
        
        // THEN DELETE THE GROUP
       echo "I am inside isset group id";
       $sql = "DELETE FROM groups WHERE ownerID = :userid AND ID=:groupid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':groupid'=>$group_id
                ));
        
        
       // THEN DELETE THE TASKS
       echo "DELETING groups has ran sucessfully";
       $sql = "DELETE FROM tasks WHERE userID = :userid AND groupID=:groupid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':groupid'=>$group_id
                ));
        header("HTTP/1.1 200 OK"); 
      
    }
    
    // DELETING TASKS
    else if(isset($_POST['task_id'])) {
       echo "I am inside isset task id";
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