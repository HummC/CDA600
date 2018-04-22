<?php
session_start();
session_regenerate_id();
header('content-type: application/json');
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    $user_id = $_SESSION['user_id'];
    $group_id = $_POST['group_id'];
    require('connect.php');
    
    
    // CHECK GROUPS TABLE TO SEE IF THERE IS ROOM
    
    
    // ADD USER TO USERGROUPS TABLE WITH SUPPLIED GROUP ID
    
    
    // UPDATE GROUPS TABLE - ADD 1 TO MEMBERS COLUMN
}

?>