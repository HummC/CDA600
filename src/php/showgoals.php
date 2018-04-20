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
    $user_id = $_SESSION['user_id'];
    require('connect.php');
       $sql = "SELECT * FROM goals WHERE userID=:userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
       $row = $statement->fetchAll(PDO::FETCH_ASSOC);
       if(!$row) {
                echo "No goals found!";
                header("HTTP/1.1 404 Not Found");
            }
            else { 
                echo json_encode($row);
                header("HTTP/1.1 200 OK");
                
            }
}

?>