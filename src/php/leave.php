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
    
            // REMOVE USER FROM USERGROUPS TABLE WITH SUPPLIED GROUP ID
            $sql = "DELETE FROM usergroup WHERE groupID=:groupid AND userID=:userid";
            $statement = $conn->prepare($sql);
            $statement->execute(
            array(':userid'=>$user_id,
                 ':groupid'=>$group_id
                ));
                $count = $statement->rowCount();
            
            if($count > 0) {
           // UPDATE GROUPS TABLE - SUBTRACT 1 FROM MEMBERS COLUMN
           $sql = "UPDATE `groups` SET members=members-1 WHERE ID=:groupid";
           $statement = $conn->prepare($sql);
           $statement->execute(
           array(':groupid'=>$group_id
                ));
           header("HTTP/1.1 200 OK"); 
        }
        else {
            echo "Failed to leave";
            header("HTTP/1.1 400 Bad request");
            die();
        }
}

?>