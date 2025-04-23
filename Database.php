//Create database
CREATE DATABASE user_details;
USE  user_details ;

CREATE TABLE user(
username VARCHAR(10) ,
password VARCHAR(10));

index.html
<html>
<head>
    <title>login form</title>
    <form method="post" action="login.php">
        <label for="username">Username:</label><br>
        <input type="text"id="username"name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password"id="password"name="password"><br>
        <input type="submit"value="login">
    </form>
</body>
</html>

login.php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_details";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST["username"]);
    $password = sanitize($_POST["password"]);
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password.";
    }
}
$conn->close();
?>
