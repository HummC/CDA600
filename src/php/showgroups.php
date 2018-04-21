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
    
    else if(isset($_GET['group_id'])) {
       $groupid = htmlspecialchars($_GET['group_id']);
       $sql = "SELECT * FROM groups WHERE ID=:groupid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':groupid'=>$groupid
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
        
        // We want to show group members if a group id is supplied. This is because if a
        // group id supplied it means that an individual is viewing a specific group, and
        // information relevant to that group involves members. to get member information
        // we need to relate users to groups via the bridge table usergroups and
        // get information from both the users and groups table to display to the front-end.
        
        $sqltwo = "SELECT u.image_loc, u.name, u.id, g.groupID, g.userID FROM users AS u, usergroup AS g WHERE g.groupID=:groupid AND g.userID = u.ID";
        $statement = $conn->prepare($sqltwo);
        $statement->execute(
           array(':groupid'=>$groupid
                ));
        $rowtwo = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rowtwo); 
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