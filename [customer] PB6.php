CREATE DATABASE partb6;
USE customerdetails;

CREATE DATABASE partb6(customer_id INT PRIMARY KEY,
customer_name VARCHAR(30),
item_purchased VARCHAR(50),
mobile_number VARCHAR(11) );

<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "partb6";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) 
{
    die("Connection failed: " . $conn->connect_error);
}
function addCustomer($name, $item, $mobile) 
{
    global $conn; 
    $sql = "INSERT INTO customers (customer_name, item_purchased, mobile_number) VALUES ('$name', '$item', '$mobile')";
    if ($conn->query($sql) === TRUE) 
     echo "Customer information added successfully.";
    else 
        echo "Error: " . $sql . "<br>" . $conn->error;

}
function deleteCustomer($id) 
{
    global $conn;
    $sql = "DELETE FROM customers WHERE customer_id = $id";
    if ($conn->query($sql)) 
    {
        if($conn->affected_rows>0)
            echo "Customer record deleted successfully!";
        else 
            echo "Error deleting record: " . $conn->error;
    }
}
function searchCustomer($id)
{
    global $conn;
    $sql = "SELECT * FROM customers WHERE customer_id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        while ($row = $result->fetch_assoc()) 
        {
            echo "Customer ID: " . $row["customer_id"] . "<br>";
            echo "Customer Name: " . $row["customer_name"] . "<br>";
            echo "Item Purchased: " . $row["item_purchased"] . "<br>";
            echo "Mobile Number: " . $row["mobile_number"] . "<br>";
        }
    } 
    else 
    {
        echo "No matching records found.";
    }
}
function sortById() 
{
    global $conn;
    $sql = "SELECT * FROM customers ORDER BY customer_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        while ($row = $result->fetch_assoc()) 
        {
            echo "Customer ID: " . $row["customer_id"] . ", ";
            echo "Customer Name: " . $row["customer_name"] . ", ";
            echo "Item Purchased: " . $row["item_purchased"] . ", ";
            echo "Mobile Number: " . $row["mobile_number"] . "<br>";
        }
    } 
    else 
    {
    echo "No records found.";
    }
}
function displayRecords() 
{
    global $conn;
    $sql = "SELECT * FROM customers";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
    {
    while ($row = $result->fetch_assoc()) 
        {
            echo "Customer ID: " . $row["customer_id"] . ", ";
            echo "Customer Name: " . $row["customer_name"] . ", ";
            echo "Item Purchased: " . $row["item_purchased"] . ", ";
            echo "Mobile Number: " . $row["mobile_number"] . "<br>";
        }
    } 
    else 
    {
        echo "No records found.";
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST["add_customer"])) 
        addCustomer($_POST["customer_name"], $_POST["item_purchased"], $_POST["mobile_number"]);
    elseif (isset($_POST["delete_record"])) 
        deleteCustomer($_POST["customer_id"]);
    elseif (isset($_POST["search_entry"])) 
        searchCustomer($_POST["customer_id"]);
}
?>

<html>
<head>
<title>Customer Information Management</title>
</head>
<body>
<button onclick="document.getElementById('add_form').style.display='block'">Add Customer Information</button>
<div id="add_form" style="display:none;">
    <form method="post">
        Customer Name: <input type="text" name="customer_name" required><br>
        Item Purchased: <input type="text" name="item_purchased" required><br>
        Mobile Number: <input type="text" name="mobile_number" pattern="[0-9]{10}" title="Enter a 10-digit mobile number" required><br>
        <input type="submit" name="add_customer" value="Add Customer">
    </form>
</div>
<button onclick="document.getElementById('delete_form').style.display='block'">Delete Customer Records</button>
<div id="delete_form" style="display:none;">
    <form method="post">
        Customer ID: <input type="text" name="customer_id" required><br>
        <input type="submit" name="delete_record" value="Delete Record">
         </form>
</div>
<button onclick="document.getElementById('search_form').style.display='block'">Search for Particular Entries</button>
<div id="search_form" style="display:none;">
    <form method="post">Customer ID: <input type="text" name="customer_id" required><br>
        <input type="submit" name="search_entry" value="Search">
    </form>
</div>
<button onclick="document.getElementById('sort_btn').style.display='block'">Sort Database Based on Customer Id</button>
<div id="sort_btn" style="display:none;">
<?php sortById(); ?>
</div>
<button onclick="document.getElementById('display_records').style.display='block'">Display Complete Set of Records</button>
<div id="display_records" style="display:none;">
<?php displayRecords(); ?>
</div>
</body>
</html>
<?php
$conn->close();
?>
