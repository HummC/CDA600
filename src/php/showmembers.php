
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
        if(isset($_GET['group_id'])) {
            $groupid = $_GET['group_id'];
                 $sql = "SELECT u.image_loc, u.name, ug.groupID FROM users as u, usergroup as ug WHERE u.ID = ug.userID  AND ug.groupID = :groupid";
                   $statement = $conn->prepare($sql);
                   $statement->execute(
                       array(':groupid'=>$groupid
                            
                            ));
        
                $userList = $statement->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($userList);
                header("HTTP/1.1 200 OK");
                
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
