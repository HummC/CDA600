<?php
$host = 'localhost'; // HOSTNAME - USUALLY LOCALHOST UNLESS THE DATABASE IS HOSTED ON A SEPERATE SERVER
$db = 'cda600'; // DATABASE NAME, CDA600 TO KEEP IT SIMPLE
$username = 'root'; // USERNAME
$password = '';  // This will be generated for a real host, but for local development we wont include one.

try {
      $conn = new PDO("mysql:host=$host;dbname=$db", $username);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } 
  catch(PDOException $excp) {
            echo $excp->getMessage();
            die();
                }
        
?>