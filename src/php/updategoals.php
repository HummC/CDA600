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
    if(!isset($_POST['goalid'])) {
        header("HTTP/1.1 400 Bad request");
        die();
    }
    else {
     $goal_id = $_POST['goalid'];   
    }
    
    
    // CHECK IF IS SET AND CHECK IF NOT EMTPY - IF START DATE IS EMPTY THEN ASSUME TODAYS DATE. OPTIONAL FIELDS CAN BE EMPTY
    
    if(isset($_POST['goalname']) && isset($_POST['goalcat']) && isset($_POST['goalstart']) && isset($_POST['goalend']) && isset($_POST['goaltn'])) {
        require('connect.php');
        // GET existing information again, just incase fields are not filled out. I don't have time to separately validate right now so I will instead update all fields but select existing values for those left empty instead of using separate update statements.
         $sqltwo = "SELECT * FROM goals WHERE userID=:userid AND ID=:goalid";
       $statement = $conn->prepare($sqltwo);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':goalid'=>$goal_id
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC); 
        
        if(!$row) {
          echo "That goal doesn't exist!, or you're unauthorised to view it!";
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
        }
        
        // Woah that's alot of if statements, could probably optimise using functions and loops but don't have the time. If it works, it works! This is a prototype afterall and the time difference is marginal and shouldn't effect the user or testing methodology.
        if(!empty($_POST['goalname'])) {
            $goalName = htmlspecialchars($_POST['goalname']);
        }
        else {
            $goalName = $row['name'];
        }
        if(!empty($_POST['goalcat'])) {
            $goalCat = htmlspecialchars($_POST['goalcat']);
        }
        
        else {
            // category is equal to the existing category
            $goalCat = $tempcat;
        }
        if(!empty($_POST['goalstart'])) {
           $goalStart = htmlspecialchars($_POST['goalstart']); 
        }
        else {
            // start goal is equal to the existing start goal
            $goalStart = $tempstart;
        }
        if(!empty($_POST['goalend'])) {
            $goalEnd = htmlspecialchars($_POST['goalend']);
        }
        else {
            // end date is equal to the existing end date
            $goalEnd = $tempend;
        }
       if(!empty($_POST['goaltn'])) {
           $goalTN = htmlspecialchars($_POST['goaltn']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $goalTN = $temptn;
        }
        
        if(!empty($_POST['goaldif'])) {
           $goalDif = htmlspecialchars($_POST['goaldif']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $goalDif = $tempdiff;
        }
        
        if(!empty($_POST['goalimp'])) {
           $goalImp = htmlspecialchars($_POST['goalimp']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $goalImp = $tempimp;
        }
        if(!empty($_POST['goaldesc'])) {
           $goalDesc = htmlspecialchars($_POST['goaldesc']);
       }
        
        else {
            // taskNo equal to the existing task number 
            $goalDesc = $tempdesc;
        }
        
    
    // INSERT STATEMENT  
       $sql = "UPDATE `goals` SET `name`=:name,`category`=:category,`start_date`=:start,`end_date`=:end,`description`=:desc,`importance`=:imp,`difficulty`=:diff,`taskNo`=:taskNo WHERE userID = :userid AND ID=:goalid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':goalid'=>$goal_id,
                 ':name'=>$goalName,
                 ':category'=>$goalCat,
                 ':start'=>$goalStart,
                 ':end'=>$goalEnd,
                 ':desc'=>$goalDesc,
                 ':imp'=>$goalImp,
                 ':diff'=>$goalDif,
                 ':taskNo'=>$goalTN
                ));
                header("HTTP/1.1 200 OK");
    }
    
    else {
        header("HTTP/1.1 400 Bad request");
    }
}

?>