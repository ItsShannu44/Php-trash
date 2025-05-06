CREATE DATABASE partb8;
USE hotel reservation;
CREATE DATABASE partb8(room_number INT(10),
room_type VARCHAR(50),
capacity INT(11), 
status VARCHAR(20));
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="partb8";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection failed:".$conn->connect_error);
}
function addRecord($room_number, $room_type, $capacity, $status) 
{
    global $conn;
    $sql = "INSERT INTO rooms (room_number, room_type, capacity, status) VALUES ('$room_number', '$room_type', '$capacity', '$status')";
  if ($conn->query($sql)) {
    echo "Record added successfully.<br>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
function listAvailableRooms(){
    global $conn;
    $sql="SELECT * FROM rooms WHERE status='available'";
    $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    echo "<h3>Available Rooms:</h3>";
    while ($row = $result->fetch_assoc()) {
      echo "Room Number: " . $row["room_number"] . ", ";
      echo "Room Type: " . $row["room_type"] . ", ";
      echo "Capacity: " . $row["capacity"] . "<br>";
    }
    }
    else{
        echo "No available rooms.";
    }
}
function listBookedRooms() {
    global $conn;
     $sql = "SELECT * FROM rooms WHERE status = 'booked'";
    $result = $conn->query($sql);
     if ($result->num_rows > 0) {
      echo "<h3>Booked Rooms:</h3>";
      while ($row = $result->fetch_assoc()) {
        echo "Room Number: " . $row["room_number"] . ", ";
        echo "Room Type: " . $row["room_type"] . ", ";
        echo "Capacity: " . $row["capacity"] . "<br>";
      }
    } else {
      echo "No booked rooms.";
    }
  }
  function checkIn($room_number) 
{
  global $conn;
  $sql = "UPDATE rooms SET status = 'booked' WHERE room_number = $room_number"; 
  if ($conn->query($sql))
  {
    if($conn->affected_rows>0)
      echo "Check-in successful for Room Number: $room_number.<br>";
    else 
      echo "This room is not available <br>";
  }
}
function checkOut($room_number) {
  global $conn;
  $sql = "UPDATE rooms SET status = 'available' WHERE room_number = $room_number";
  if ($conn->query($sql))
  {
    if($conn->affected_rows>0)
      echo "Check-out successful for Room Number: $room_number.<br>";
    else 
      echo "This room is not available <br>";
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (isset($_POST["add_record"])) 
  {
    addRecord($_POST["room_number"], $_POST["room_type"], $_POST["capacity"],$_POST["status"]);
  } 
  elseif (isset($_POST["check_in"])) 
  {
    checkIn($_POST["room_number"]);
  } 
  elseif (isset($_POST["check_out"])) 
  {
    checkOut($_POST["room_number"]);
  }
}
?>
<html>
<head>
  <title>Hotel Reservation</title>
</head>
<body>
<h2>Add Record</h2>
<form method="post">
  Room Number: <input type="number" name="room_number" required><br>
 <br> 
Room Type:<select name="room_type" required>
<option value="single semi">single semi</option>
<option value="single deluxe">single deluxe</option>
<option value="double semi">double semi</option>
<option value="double deluxe">double deluxe</option>
<option value="dormitory">dormitory</option>
</select>
  <br><br>
  Capacity: <input type="number" name="capacity" required><br><br>
  Status (available/booked): <input type="text" name="status" required><br><br>
  <input type="submit" name="add_record" value="Add Record">
</form>
<h2>Check-in</h2>
<form method="post">
  Room Number: <input type="number" name="room_number" required><br>
  <input type="submit" name="check_in" value="Check-in">
</form>
<h2>Check-out</h2>
<form method="post">
  Room Number: <input type="number" name="room_number" required><br>
  <input type="submit" name="check_out" value="Check-out">
</form>
<?php listAvailableRooms(); ?>
<?php listBookedRooms(); ?>
</body>
</html>
<?php
$conn->close();
?>
