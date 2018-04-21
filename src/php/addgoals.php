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
    
    // READ IN VARIABLES TO BE INPUTED
    
    
    $user_id = $_SESSION['user_id'];
    
    
    // CHECK IF IS SET AND CHECK IF NOT EMTPY - IF START DATE IS EMPTY THEN ASSUME TODAYS DATE. OPTIONAL FIELDS CAN BE EMPTY
    
    if(isset($_POST['goalname']) && isset($_POST['goalcat']) && isset($_POST['goalstart']) && isset($_POST['goalend']) && isset($_POST['goaltn'])) {
        if(!empty($_POST['goalname'])) {
            $goalName = htmlspecialchars($_POST['goalname']);
        }
        else {
         echo "Name required";   
        }
        if(!empty($_POST['goalcat'])) {
            $goalCat = htmlspecialchars($_POST['goalcat']);
        }
        
        else {
            echo "Category required";
        }
        if(!empty($_POST['goalstart'])) {
           $goalStart = htmlspecialchars($_POST['goalstart']); 
        }
        else {
            $goalStart  = date('Y/m/d');
        }
        if(!empty($_POST['goalend'])) {
            $goalEnd = htmlspecialchars($_POST['goalend']);
        }
        else {
            echo "Due date is required";
        }
       if(!empty($_POST['goaltn'])) {
           $goalTN = htmlspecialchars($_POST['goaltn']);
       }
        
        else {
           $goalTN = 3; 
        }
        
    $goalDif = htmlspecialchars($_POST['goaldif']);
    $goalImp = htmlspecialchars($_POST['goalimp']);
    $goalDesc = htmlspecialchars($_POST['goaldesc']);
    
    // INSERT STATEMENT  
      require('connect.php');
       $sql = "INSERT INTO `goals`(`ID`, `name`, `category`, `start_date`, `end_date`, `description`, `importance`, `difficulty`, `status`, `taskNo`, `userID`) VALUES (NULL,:name,:category,:start,:end,:desc,:imp,:diff,'pending',:taskNo,:userid)";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id,
                 ':name'=>$goalname,
                 ':category'=>$goalcat,
                 ':start'=>$goalstart,
                 ':end'=>$goalend,
                 ':desc'=>$goalDesc,
                 ':imp'=>$goalImp,
                 ':diff'=>$goalDif,
                 ':taskNo'=>$goalTN
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
       if(!$row) {
                echo "Insert failed!";
                header("HTTP/1.1 415 Conflict!");
            }
            else { 
                echo json_encode($row['ID'],$goalname,$goalcat,$goalstart,$goalend,$goalDesc,$goalImp,$goalDif,$goalTN);
                header("HTTP/1.1 200 OK");
                
            }
    }
    
    else {
        header("HTTP/1.1 400 Bad request");
    }
    
    
    
    // INSERT INTO GOALS 
    
    
    
    // SELECT GOAL FROM GOALS AND RETURN AS JSON
}

?>