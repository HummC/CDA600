<?php
session_start();
session_regenerate_id();
header('content-type: application/json');
// WE WANT THE RESPONSE TO CONTAIN JSON, SO WE MUST SPECIFY THE CONTENT TYPE IN THE HEADER
// OTHERWISE IT MAY ASSUME WE ARE RETURNING STANDARD HTML
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    
    // DEFINE VARIABLES THAT NEED GLOBAL SCOPE
    $tempname;
    $tempstart;
    $tempend;
    $tempdesc;
    $temploc;
    
    
    
    $user_id = $_SESSION['user_id'];
    if(!isset($_POST['taskid'])) {
        header("HTTP/1.1 400 Bad request");
        die();
    }
    else {
     $task_id = $_POST['taskid'];   
    }
    
    // I AM HERE - NEXT IS TO LOOK AT FIELDS REQUIRED FOR UPDATING taskS THEN CHANGING THEM FOR taskS TABLE.
    // CHECK IF IS SET AND CHECK IF NOT EMTPY - IF START DATE IS EMPTY THEN ASSUME TODAYS DATE. OPTIONAL FIELDS CAN BE EMPTY
    
    if(isset($_POST['taskname']) && isset($_POST['taskstart']) && isset($_POST['taskend']))  {
        require('connect.php');
        // GET existing information again, just incase fields are not filled out. I don't have time to separately validate right now so I will instead update all fields but select existing values for those left empty instead of using separate update statements.
       $sqltwo = "SELECT * FROM tasks WHERE userID=:userid AND ID=:taskid";
       $statement = $conn->prepare($sqltwo);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':taskid'=>$task_id
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC); 
        
        if(!$row) {
          header("HTTP/1.1 400 Bad request");
          die();
        }
        
        else {
        // VARIABLES LIE IN SAME SCOPE ANYWAY SO NO WORRIES.
       $tempname = $row[0]['name'];
       $temploc = $row[0]['location'];
       $tempstart = $row[0]['start_date'];
       $tempend = $row[0]['due_date'];
       $tempdesc = $row[0]['description'];
     
        }
        
        if(!empty($_POST['taskname'])) {
            $taskName = htmlspecialchars($_POST['taskname']);
        }
        else {
            $taskName = $tempname;
        }
        if(!empty($_POST['tasklocation'])) {
            $taskLoc = htmlspecialchars($_POST['tasklocation']);
        }
        
        else {
            // category is equal to the existing category
            $taskLoc = $temploc;
        }
        if(!empty($_POST['taskstart'])) {
           $taskStart = htmlspecialchars($_POST['taskstart']); 
        }
        else {
            // start goal is equal to the existing start goal
            $taskStart = $tempstart;
        }
        if(!empty($_POST['taskend'])) {
            $taskEnd = htmlspecialchars($_POST['taskend']);
        }
        else {
            // end date is equal to the existing end date
            $taskEnd = $tempend;
        }
    

        if(!empty($_POST['taskdesc'])) {
           $taskDesc = htmlspecialchars($_POST['taskdesc']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $taskDesc = $tempdesc;
        }
        
    
    // INSERT STATEMENT  
       $sql = "UPDATE `tasks` SET `name`=:name,`start_date`=:start,`due_date`=:end,`description`=:desc WHERE userID = :userid AND ID=:taskid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':taskid'=>$task_id,
                 ':name'=>$taskName,
                 ':start'=>$taskStart,
                 ':end'=>$taskEnd,
                 ':desc'=>$taskDesc
                ));
                header("HTTP/1.1 200 OK");
    }
    
    else {
        header("HTTP/1.1 400 Bad request");
    }
}

?>