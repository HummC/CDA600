<?php
session_start();
session_regenerate_id();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    die();
}
else {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>goalsetter</title>
    <link rel="stylesheet" type="text/css" href="./css/app.css">
  </head>
  <body>
   <a href="php/logout.php">Logout</a>
    <div id="app"></div>
    <script src="./build.js"></script>
  </body>
</html>
<?php
}
?>