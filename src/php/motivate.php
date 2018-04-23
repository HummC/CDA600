
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
// check if task id is set
if(isset($_POST['task_id'])) {
    if(!empty($_POST['task_id'])) {
        $taskid = $_POST['task_id'];
        // check if userid and taskid are present in the taskmotivator table
        $sql = "SELECT t.userID, t.ID, tm.taskID, tm.userID FROM tasks AS t, taskmotivator AS tm WHERE tm.taskID=:taskid AND tm.userID=:userid";
        $statement = $conn->prepare($sql);
        $statement->execute(
           array(':userid'=>$user_id,
                 ':taskid'=>$taskid
                ));
    $row = $statement->fetchAll(PDO::FETCH_ASSOC);
    if(!$row) {
        echo "You haven't liked yet!";
        // Add userid and taskid to task motivator
        $sql = "INSERT INTO taskmotivator (userID,taskID) VALUES (:userid, :taskid)";
        $statement = $conn->prepare($sql);
        $statement->execute(
           array(':userid'=>$user_id,
                 ':taskid'=>$taskid
                ));
        
        // Update motivates + 1
        $sql = "UPDATE tasks SET motivates=motivates+1 WHERE ID=:taskid";
        $statement = $conn->prepare($sql);
        $statement->execute(
           array(
                 ':taskid'=>$taskid
                ));
    
    header("HTTP/1.1 200 OK"); 
    die();
    }
    else {
        echo "You already liked, so we remove!";
        // Remove motivates from taskmotivator
        $sql = "DELETE FROM taskmotivator WHERE taskID=:taskid AND userID=:userid";
        $statement = $conn->prepare($sql);
        $statement->execute(
           array(':userid'=>$user_id,
                 ':taskid'=>$taskid
                ));
        
        // Update tasks motivates
        $sql = "UPDATE tasks SET motivates=motivates-1 WHERE ID=:taskid";
        $statement = $conn->prepare($sql);
        $statement->execute(
           array(
                 ':taskid'=>$taskid
                ));
    header("HTTP/1.1 200 OK"); 
    die();
    }
        }
        else {
            // TASK ID IS EMTPY - BAD REQUEST
            header("HTTP/1.1 400 Bad request");
            die();
        }
    }
    else {
        // TASK ID NOT SET - BAD REQUEST
          header("HTTP/1.1 400 Bad request");
          die();
    }
}
?>