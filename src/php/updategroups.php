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
    $tempcat;
    $tempstart;
    $tempend;
    $temptn;
    $tempdiff;
    $tempimp;
    $tempdesc;
    
    
    
    $user_id = $_SESSION['user_id'];
    if(!isset($_POST['groupid'])) {
        header("HTTP/1.1 400 Bad request");
        die();
    }
    else {
     $group_id = $_POST['groupid'];   
    }
    
    // I AM HERE - NEXT IS TO LOOK AT FIELDS REQUIRED FOR UPDATING GROUPS THEN CHANGING THEM FOR GROUPS TABLE.
    // CHECK IF IS SET AND CHECK IF NOT EMTPY - IF START DATE IS EMPTY THEN ASSUME TODAYS DATE. OPTIONAL FIELDS CAN BE EMPTY
    
    if(isset($_POST['groupname']) && isset($_POST['groupcat']) && isset($_POST['groupstart']) && isset($_POST['groupend']) && isset($_POST['grouptn']) && isset($_POST['groupsize'])) {
        require('connect.php');
        // GET existing information again, just incase fields are not filled out. I don't have time to separately validate right now so I will instead update all fields but select existing values for those left empty instead of using separate update statements.
       $sqltwo = "SELECT * FROM groups WHERE ownerID=:userid AND ID=:groupid";
       $statement = $conn->prepare($sqltwo);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':groupid'=>$group_id
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC); 
        
        if(!$row) {
          header("HTTP/1.1 400 Bad request");
          die();
        }
        
        else {
        // VARIABLES LIE IN SAME SCOPE ANYWAY SO NO WORRIES.
       $tempname = $row[0]['name'];
       $tempcat = $row[0]['category'];
       $tempstart = $row[0]['start_date'];
       $tempend = $row[0]['end_date'];
       $temptn = $row[0]['taskNo'];
       $tempdiff = $row[0]['difficulty'];
       $tempimp = $row[0]['importance'];
       $tempdesc = $row[0]['description'];
       $tempsize = $row[0]['size'];
        }
        
        if(!empty($_POST['groupname'])) {
            $groupName = htmlspecialchars($_POST['groupname']);
        }
        else {
            $groupName = $tempname;
        }
        if(!empty($_POST['groupcat'])) {
            $groupCat = htmlspecialchars($_POST['groupcat']);
        }
        
        else {
            // category is equal to the existing category
            $groupCat = $tempcat;
        }
        if(!empty($_POST['groupstart'])) {
           $groupStart = htmlspecialchars($_POST['groupstart']); 
        }
        else {
            // start goal is equal to the existing start goal
            $groupStart = $tempstart;
        }
        if(!empty($_POST['groupend'])) {
            $groupEnd = htmlspecialchars($_POST['groupend']);
        }
        else {
            // end date is equal to the existing end date
            $groupEnd = $tempend;
        }
       if(!empty($_POST['grouptn'])) {
           $groupTN = htmlspecialchars($_POST['grouptn']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $groupTN = $temptn;
        }
        
        if(!empty($_POST['groupdif'])) {
           $groupDif = htmlspecialchars($_POST['groupdif']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $groupDif = $tempdiff;
        }
        
        if(!empty($_POST['groupimp'])) {
           $groupImp = htmlspecialchars($_POST['groupimp']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $groupImp = $tempimp;
        }
        if(!empty($_POST['groupdesc'])) {
           $groupDesc = htmlspecialchars($_POST['groupdesc']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $groupDesc = $tempdesc;
        }
        
        if(!empty($_POST['groupsize'])) {
            $groupSize = htmlspecialchars($_POST['groupsize']);
        }
        
        else {
           $groupSize = $tempsize; 
        }
        
    
    // INSERT STATEMENT  
       $sql = "UPDATE `groups` SET `name`=:name,`category`=:category,`start_date`=:start,`end_date`=:end,`description`=:desc,`importance`=:imp,`difficulty`=:diff,`taskNo`=:taskNo, size = :groupsize WHERE ownerID = :userid AND ID=:groupid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':groupid'=>$group_id,
                 ':name'=>$groupName,
                 ':category'=>$groupCat,
                 ':start'=>$groupStart,
                 ':end'=>$groupEnd,
                 ':desc'=>$groupDesc,
                 ':imp'=>$groupImp,
                 ':diff'=>$groupDif,
                 ':taskNo'=>$groupTN,
                 ':groupsize'=>$groupSize
                ));
                header("HTTP/1.1 200 OK");
    }
    
    else {
        header("HTTP/1.1 400 Bad request");
    }
}

?>