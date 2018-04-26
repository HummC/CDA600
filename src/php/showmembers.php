
<?php
session_start();
session_regenerate_id();
header('content-type: application/json');
// CHECK THAT USER IS AUTHORISED TO RUN THIS SCRIPT
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    require('connect.php');
    if(isset($_GET['group_id'])) {
    $taskid = $_GET['group_id'];
        // SELECT USERS WHO BELONG TO GROUP WITH GROUP ID PASSED
        // TRY INCLUDE GROUP MEMBERS AS PART OF THE SINGLE STATEMENT WHICH RETURNS TO MYGROUPS. THAT WAY
        // WE CAN JUST ACCESS THE DATA IN THE FOR LOOP WHICH CYCLES THROUGH MYGROUPS. SO WE JUST NEED TO
        // WORK OUT THE SQL TO INCLUDE USERS.
      $sqltwo = "SELECT u.image_loc, u.name, u.id, g.groupID, g.userID FROM users AS u, usergroup AS g WHERE g.groupID=:groupid AND g.userID = u.ID";
        $statement = $conn->prepare($sqltwo);
        $statement->execute(
           array(':groupid'=>$groupid
                ));
        $rowtwo = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($rowtwo);    
    }
    else {
        // NOT SET DISPLAY NOTHING
    }
}
