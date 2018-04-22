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
    
    
    // For single group pages, we need a way to pass back the information
    // Axios will show groups for the owner or all groups. The group id will
    // be stored by the event triggered and passed via route parameters to
    // the group-single component. Using the created life-cycle hook, this script
    // will then be requested again passing the group_id as a query parameter. 
    // Information for that single group will then be returned and mounted using
    // Vue.
    
    
    // If we are looking at the single group page, then we also need information on group members
    // aswell as the group itself. As such as will need to make two additional queries. One to
    // link members to the group through the usergroups table and one to link user information to
    // to the userID through the users table.
    
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