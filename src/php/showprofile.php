<?php
session_start();

// WE WANT THE RESPONSE TO CONTAIN JSON, SO WE MUST SPECIFY THE CONTENT TYPE IN THE HEADER
// OTHERWISE IT MAY ASSUME WE ARE RETURNING STANDARD HTML
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    $user_id = $_SESSION['user_id'];
    require('connect.php');
       $sql = "SELECT image_loc, name, bio FROM users WHERE ID=:userid";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':userid'=>$user_id
                ));
      $row = $statement->fetch();
       if(!$row) {
                header("HTTP/1.1 404 Not Found");
            }
            else { 
                ?>
                <img src="../<?php echo $row['image_loc']?>">
                <h1><?php echo $row['name']?></h1>
                <p><?php echo $row['bio']?></p>
                <?php
                header("HTTP/1.1 200 OK");
                
            }
}

?>