<?php
session_start();
session_regenerate_id();
header('content-type: application/json');
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    
    // READ IN VARIABLES TO BE INPUTED
    
    
    $user_id = $_SESSION['user_id'];
    
    
    // CHECK IF IS SET AND CHECK IF NOT EMTPY - IF START DATE IS EMPTY THEN ASSUME TODAYS DATE. OPTIONAL FIELDS CAN BE EMPTY
    
    if(isset($_POST['groupname']) && isset($_POST['groupcat']) && isset($_POST['groupstart']) && isset($_POST['groupend']) && isset($_POST['grouptn'])) {
        if(!empty($_POST['groupname'])) {
            $groupName = htmlspecialchars($_POST['groupname']);
        }
        else {
         echo "Name required";
         header("HTTP/1.1 400 Bad request");
         die();
        }
        if(!empty($_POST['groupcat'])) {
            $groupCat = htmlspecialchars($_POST['groupcat']);
        }
        
        else {
            echo "Category required";
            header("HTTP/1.1 400 Bad request");
            die();
        }
        if(!empty($_POST['groupstart'])) {
           $groupStart = htmlspecialchars($_POST['groupstart']); 
        }
        else {
            $groupStart  = date('Y/m/d');
        }
        if(!empty($_POST['groupend'])) {
            $groupEnd = htmlspecialchars($_POST['groupend']);
        }
        else {
            echo "Due date is required";
            header("HTTP/1.1 400 Bad request");
            die();
        }
       if(!empty($_POST['grouptn'])) {
           $groupTN = htmlspecialchars($_POST['grouptn']);
       }
        
        else {
           $groupTN = 3; 
        }
        
         if(!empty($_POST['groupsize'])) {
           $groupSize = htmlspecialchars($_POST['groupsize']);
       }
        
        else {
           $groupSize = 4; 
        }
        
        
         if(!empty($_POST['groupmembers'])) {
           $groupMembers = htmlspecialchars($_POST['groupmembers']);
       }
        
        else {
            // when first creating the group, there is no way that the members can be 0, as the owner themselves count as a member and the member integer is a dependancy of the size column and the join/leave.php scripts
           $groupMembers = 1; 
        }
        
    $groupDif = htmlspecialchars($_POST['groupdif']);
    $groupImp = htmlspecialchars($_POST['groupimp']);
    $groupDesc = htmlspecialchars($_POST['groupdesc']);
    
    // INSERT STATEMENT  
      require('connect.php');
       $sql = "INSERT INTO `groups`(`ID`, `name`, `category`, `start_date`, `end_date`, `description`, `importance`, `difficulty`, `status`, `taskNo`, `size`, `members`, `ownerID`) VALUES (NULL,:name,:category,:startdate,:enddate,:description,:importance,:difficulty,'pending',:taskno,:gsize,:gmembers,:userid)";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':name'=>$groupName,
                 ':category'=>$groupCat,
                 ':startdate'=>$groupStart,
                 ':enddate'=>$groupEnd,
                 ':description'=>$groupDesc,
                 ':importance'=>$groupImp,
                 ':difficulty'=>$groupDif,
                 ':taskno'=>$groupTN,
                 ':gsize'=>$groupSize,
                 ':gmembers'=>$groupMembers
                ));
      $sqltwo = "SELECT ID, name, category, start_date, end_date, description, importance, difficulty, status, taskNo, members, size FROM groups WHERE ownerID=:userid AND name = :name AND start_date = :date";
       $statement = $conn->prepare($sqltwo);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':name'=>$groupName,
                 ':date'=>$groupStart
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
        
                header("HTTP/1.1 200 OK");
                
    }
    
    else {
        header("HTTP/1.1 400 Bad request");
    }
    
    
    
    // INSERT INTO GOALS 
    
    
    
    // SELECT GOAL FROM GOALS AND RETURN AS JSON
}

?>