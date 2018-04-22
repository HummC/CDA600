<?php
session_start();
session_regenerate_id();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    $user_id = $_SESSION['user_id'];
    $group_id = $_POST['group_id'];
    require('connect.php');
    
    
    // CHECK GROUPS TABLE TO SEE IF THERE IS ROOM
       $sqltwo = "SELECT * FROM groups WHERE ID=:groupid";
       $statement = $conn->prepare($sqltwo);
       $statement->execute(
           array(
                 ':groupid'=>$group_id
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC); 
    
    if(!$row) {
        echo "That group no longer exists! Sorry.";
    }
    else {
        if($row['members'] < $row['size']) {
            echo "This group is accepting people";
          // CHECK TO SEE IF USER ALREADY BELONGS TO THAT GROUP
        $sql = "SELECT * FROM usergroups WHERE groupID = :groupid AND userID = :userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':groupid'=>$group_id
                ));
        $rowtwo = $statement->fetchAll(PDO::FETCH_ASSOC); 
        
            
        
        if(!$rowtwo) {
            // ADD USER TO USERGROUPS TABLE WITH SUPPLIED GROUP ID
            $sql = "INSERT INTO `usergroup`(`groupID`, `userID`) VALUES (:groupid,:userid)";
            $statement = $conn->prepare($sql);
            $statement->execute(
            array(':userid'=>$user_id,
                 ':groupid'=>$group_id
                ));
                $count = $statement->rowCount();
            
            if($count > 0) {
           // UPDATE GROUPS TABLE - ADD 1 TO MEMBERS COLUMN
           $sql = "UPDATE `groups` SET `members' = 'members' + 1 WHERE ID=:groupid";
           $statement = $conn->prepare($sql);
           $statement->execute(
           array(':groupid'=>$group_id
                ));
           header("HTTP/1.1 200 OK"); 
        }
        else {
            echo "Failed to insert";
            header("HTTP/1.1 400 Bad request");
            die();
        }
        }
            
        else {
           echo "You already belong to that group!";
           header("HTTP/1.1 400 Bad request");
           die();
        }
            
        
        }
        else {
        echo "That group is full, sorry!";
        header("HTTP/1.1 400 Bad request");
        die();
        }
    }
}

?>