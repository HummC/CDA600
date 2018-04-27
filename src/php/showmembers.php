
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
         $sql = "SELECT g.ID, g.name, g.start_date, g.end_date, g.status, g.importance, g.description, g.category FROM groups as g, usergroup as u WHERE g.ID = u.groupID AND u.userID = :userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
        
       $groupList = $statement->fetchAll(PDO::FETCH_ASSOC);
       $groupid = [];
       foreach($groupList as $row) {
           $groupid = $row['ID'];
       }
       if(!$groupList) {
                echo "You have no group goals found!";
                header("HTTP/1.1 404 Not Found");
            }
            else {
                
                 $sql = "SELECT u.image_loc, u.name, ug.groupID FROM users as u, usergroup as ug WHERE u.ID = ug.userID  AND ug.groupID = :groupid";
                   $statement = $conn->prepare($sql);
                   $statement->execute(
                       array(':groupid'=>$groupid
                            
                            ));
        
                $userList = $statement->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($userList);
                header("HTTP/1.1 200 OK");
                
            }
    
    
    
    
      /*$sqltwo = "SELECT u.image_loc, u.name, u.id, g.groupID, g.userID FROM users AS u, usergroup AS g WHERE g.groupID=:groupid AND g.userID = u.ID";
        $statement = $conn->prepare($sqltwo);
        $statement->execute(
           array(':groupid'=>$groupid
                ));
        $rowtwo = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rowtwo);  
        */
    }
