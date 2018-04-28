
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
    $user_id = $_SESSION['user_id'];
        if(isset($_GET['groups'])) {
            $sql = "SELECT g.name FROM groups as g, usergroup as u WHERE g.ID = u.groupID AND u.userID = :userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
        
       $groupList = $statement->fetchAll(PDO::FETCH_ASSOC);
         echo json_encode($groupList);
         header("HTTP/1.1 200 OK");
                
            }
    
    else if(isset($_GET['goals'])) {
         $sql = "SELECT name FROM goals WHERE userID = :userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
        
       $goalList = $statement->fetchAll(PDO::FETCH_ASSOC);
         echo json_encode($goalList);
    
    
    }
    else {
        header("HTTP/1.1 400 Bad request!");
        die();
    }
}
    
    
    
    
      /*$sqltwo = "SELECT u.image_loc, u.name, u.id, g.groupID, g.userID FROM users AS u, usergroup AS g WHERE g.groupID=:groupid AND g.userID = u.ID";
        $statement = $conn->prepare($sqltwo);
        $statement->execute(
           array(':groupid'=>$groupid
                ));
        $rowtwo = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rowtwo);  
        */
