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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <title>goalsetter</title>
    <link rel="stylesheet" type="text/css" href="./css/app.css">
  </head>
  <body>
    <div id="app"></div>
      <script src="./js/vendor/axios.min.js"></script>
    <script src="./build.js"></script>
    
  </body>
</html>
<?php
}
?>