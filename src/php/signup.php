<?PHP
if(!isset($_POST['username']) || !isset($_POST['password'])) {
    header("HTTP/1.1 400 Bad Request"); 
    die();
}
else {
if(!empty($_POST['username']) && !empty($_POST['password'])) { 
$un = htmlspecialchars(strtolower($_POST['username']));
$pw = htmlspecialchars($_POST['password']);

require('connect.php');
$sql = "SELECT * FROM users WHERE username = :username";
$statement=$conn->prepare($sql);
$exec=$statement->execute(array
(
 ":username" => $un    
)
);

$row=$statement->fetch();
if($row) {
      header("HTTP/1.1 409 Conflict"); 
      die(); 
}
else {
    $pw_encrypt = md5($pw);
    $i = "INSERT INTO users (ID, Username, Password, name, bio, image_loc) VALUES (NULL, :username, :password, :name, :bio, :image_loc)";
    $prep = $conn->prepare($i);
    $results=$prep->execute(array(
        ":username" => $un,
        ":password" => $pw_encrypt,
        ":name" => $un,
        ":bio" => "This is your default bio!",
        ":image_loc" =>"images/logo.png"
    ));
    
    $_SESSION["user_id"] = $row['ID'];
    header("HTTP/1.1 200 OK");
}
}
    else {
        header("HTTP/1.1 400 Bad Request"); 
        die();
    }
}
?>