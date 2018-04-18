<?php
// Is a session initiated? If not, lets start one up so we can work with sessions.
if(!isset($_SESSION)) {
session_start();
}

// Check to see if the user has entered just a username or password, and return a bad request HTTP error.
if(isset($_POST['username']) XOR isset($_POST['password'])) {
        header("HTTP/1.1 401 Unauthorized!");  
        die();
        header('location: login.html');
}


// if not, double check that both fields are set
else if(isset($_POST['username']) && isset($_POST['password'])) {
    // if they are, check that both fields are not empty
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
       
        // If both fields are not empty, then store the POSTED username and password
        // in variables. Use htmlspecialchars to reduce the risk of a XSS attack and strtolower on the username as all values are lowercase in the database for consistency.
       $un = htmlspecialchars(strtolower($_POST['username']));
       $pw = htmlspecialchars($_POST['password']);
        
        // Encrypt the password using md5 hashing algorithm. This is necessary so
        // that in the unlikely event that a server/database is comprimised, users passwords are still secure.
        // It's common for users to use the same password across multiple sites so unsecured passwords are a 
        // security risk.
        
       $pw_encrypt = md5($pw);
       
        
       // Now we have validated and stored input in variables, we can setup  the connection to the database.
       require('connect.php');
        
       // Setup a prepared statement to check for rows in the database that match the users provided
       // username and password. Although we validated input, this is a double measure to prevent SQL
        // Injection attacks which could drop, manipulate and otherwise expose a database and its data.
       $sql = "SELECT * FROM users WHERE username=:username AND password=:password";
       $statement = $conn->prepare($sql);
       $statement->execute(
           array(':username'=>$un,
                 ':password'=>$pw_encrypt
                ));
       // Grab any rows that match the criteria and store them in the row variable.
       $row = $statement->fetch();
        
        // If the row variale returns at-least one result (true) we can log the user in by setting the
        // session variable to the users ID. This ID will be helpful for querying data throughout the App.
        if($row) {
            $_SESSION["user_id"] = $row['ID'];
            header('location: home.php'); 
            
        }
        // If no results match, then we will return a 401 Unauthorized and kill the connection to the database.
        else {
            header("HTTP/1.1 401 Unauthorized!");  
            die();
            header('location: login.html'); 
        }
           }
    // If either field is empty, then a user cannot authenticate so will be given a 400 bad request code
    // to communicate the missing data.
    
    else {
        header("HTTP/1.1 400 Bad Request"); 
        die();
        header('location: login.html'); 
    }
    
}

// Again, if both fields are not set, the user cannot authenticate so a 400 bad request will be returned and
// the connection to the database closed.

else {
        header("HTTP/1.1 400 Bad Request"); 
        die();
        header('location: login.html');
}




?>