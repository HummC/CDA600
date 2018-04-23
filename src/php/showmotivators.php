
<?php
session_start();
session_regenerate_id();
// CHECK THAT USER IS AUTHORISED TO RUN THIS SCRIPT
if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.html");
    die();
}

else {
    if(isset($_GET['task_id'])) {
        
    // SELECT FROM taskmotivators where taskid = task id.
        
    // STORE USER IDS IN ARRAY
        
    // SELECT FROM users WHERE ID IN myarray
        
    // JSON ENCODE ROWS
           
    }
}
