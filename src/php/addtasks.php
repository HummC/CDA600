<?php
session_start();
session_regenerate_id();
header('content-type: application/json');
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    require('connect.php');
    
    // READ IN VARIABLES TO BE INPUTED
    
    
    $user_id = $_SESSION['user_id'];
    $goalName;
    $groupName;
    
    // CHECK IF IS SET AND CHECK IF NOT EMTPY - IF START DATE IS EMPTY THEN ASSUME TODAYS DATE. OPTIONAL FIELDS CAN BE EMPTY
    
    if(isset($_POST['taskname']) && isset($_POST['taskstart']) && isset($_POST['taskend']) && isset($_POST['taskdesc'])) {
        if(!empty($_POST['taskname'])) {
            $taskName = htmlspecialchars($_POST['taskname']);
        }
        else {
         echo "Name required";
         header("HTTP/1.1 400 Bad request");
         die();
        }
        
        if(!empty($_POST['taskstart'])) {
           $taskStart = htmlspecialchars($_POST['taskstart']); 
        }
        else {
            $taskStart  = date('Y/m/d');
        }
        if(!empty($_POST['taskend'])) {
            $taskEnd = htmlspecialchars($_POST['taskend']);
        }
        else {
            echo "Due date is required";
            header("HTTP/1.1 400 Bad request");
            die();
        }
    
        if(!empty($_POST['goalname'])) {
            echo "goalname is not empty";
            $goalName = htmlspecialchars($_POST['goalname']);
            // QUERY GOALNAME AGAINST GOAL DATABASE
            $sqltwo = "SELECT ID, name FROM goals WHERE userID = :userid AND name=:goalname";
            $statement = $conn->prepare($sqltwo);
            $statement->execute(
            array(':userid'=>$user_id,
                 ':goalname'=>$goalName
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
       
       if(!$row) {
            echo "couldn't find goal";
            $goalid = NULL;
            $pname = "";
            $groupid = NULL;
       }
       else {
           echo "goal was found!";
           $goalid = $row[0]['ID'];
           $pname = $row[0]['name'];
           $groupid = NULL;
       }
        }
        else if(!empty($_POST['groupname'])) {
            $groupName = htmlspecialchars(strtolower($_POST['groupname']));
            // QUERY GOALNAME AGAINST GOAL DATABASE
            $sqltwo = "SELECT g.ID, g.name FROM groups as g, usergroup as u WHERE u.groupID = g.ID AND g.name=:groupname AND u.userID = :userid";
            $statement = $conn->prepare($sqltwo);
            $statement->execute(
            array(':userid'=>$user_id,
                 ':groupname'=>$groupName
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
       
       if(!$row) {
            $groupid = NULL;
            $pname = "";
            $goalid = NULL;
            header("HTTP/1.1 401 Unauthorized!");
            die();
           
       }
       else {
           $groupid = $row[0]['ID'];
           $pname = $row[0]['name'];
           $goalid = NULL;
       }
        }
        else {
            echo "Tasks can belong to 1 group or 1 goal, please ensure you have selected one of these";
            header("HTTP/1.1 400 Bad request");
            die(); 
        }
        

    
    if(isset($_POST['taskLoc']) && !empty($_POST['taskLoc'])) {
        $taskLoc = $_POST['taskLoc'];
    }
    else {
        $taskLoc = NULL;
    }
    $taskDesc = htmlspecialchars($_POST['taskdesc']);
    $taskEnd = $_POST['taskend'];
    
    // INSERT STATEMENT  
       $sql = "INSERT INTO `tasks`(`ID`, `parent_goal`, `name`, `due_date`, `description`, `location`, `status`, `motivates`, `comments`, `goalID`, `userID`, `groupID`, `start_date`) VALUES (NULL,:parent,:name,:enddate,:description,:location,'pending',0,0,:goalid,:userid,:groupid,:startdate)";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':name'=>$taskName,
                 ':enddate'=>$taskEnd,
                 ':description'=>$taskDesc,
                 ':location'=>$taskLoc,
                 ':goalid'=>$goalid,
                 ':groupid'=>$groupid,
                 ':startdate'=>$taskStart,
                 ':parent'=>$pname
                ));
      /*$sqltwo = "SELECT ID, name, category, start_date, end_date, description, importance, difficulty, status, taskNo, members, size FROM groups WHERE ownerID=:userid AND name = :name AND start_date = :date";
       $statement = $conn->prepare($sqltwo);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':name'=>$groupName,
                 ':date'=>$groupStart
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
        
                header("HTTP/1.1 200 OK");
                */
                
    }
    
    else {
        header("HTTP/1.1 400 Bad request");
        die();
    }
    
    
    
    // INSERT INTO GOALS 
    
}
    
    // SELECT GOAL FROM GOALS AND RETURN AS JSON

?>