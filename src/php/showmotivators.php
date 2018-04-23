
<?php
session_start();
session_regenerate_id();
header('content-type: application/json');
// CHECK THAT USER IS AUTHORISED TO RUN THIS SCRIPT
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    require('connect.php');
    if(isset($_GET['task_id'])) {
    $taskid = $_GET['task_id'];
    
    // SELECT USERS WHO MOTIVATED A PARTICULAR TASK AND RETURN AS JSON TO BE USED IN WEBPAGE.
    $sqltwo = "SELECT u.image_loc, u.name, u.id, tm.taskID, tm.userID FROM users AS u, taskmotivator AS tm WHERE tm.taskID=:taskid AND tm.userID = u.ID";
    $statement = $conn->prepare($sqltwo);
    $statement->execute(
    array(':taskid'=>$taskid
                ));
    $rowtwo = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rowtwo); 
        
           
    }
    else {
        // NOT SET DISPLAY NOTHING
    }
}
