CREATE DATABASE bookstore;
USE bookstore;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_number VARCHAR(20) NOT NULL,
    book_title VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    book_code INT NOT NULL,
    discount_rate DECIMAL(5, 2) NOT NULL,
    discount_amount DECIMAL(10, 2) NOT NULL,
    net_bill_amount DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

filename.html
<html>
    <head>
        <title>Book Shopping Form </title>
    </head>
    <body>
        <h2>Book Shopping Form </h2>
        <form method="POST" action="process_order.php">
         book Number<input type="text" name="book_number" required><br><br>
         book title<input type="text" name="book_title" required><br><br>
         price<input type="number" step="0.01" name="price" required><br><br>
         quantity<input type="text" name="quantity" required><br><br>
         book code<Select name="book_code">
        <option value="101">101</option>
        <option value="102">102</option>
        <option value="103">103</option>
        <option value="104">104</option>
         </Select><br><br>
         <input type="submit" value="submit">
        </form>
    </body>
</html>
process_order.php
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="bookstore";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error)
{
die("connection failed:".$conn->connect_error);
}
$book_number=$_POST['book_number'];
$book_title=$_POST['book_title'];
$price=$_POST['price'];
$quantity=$_POST['quantity'];
$book_code=$_POST['book_code'];
switch ($book_code) {
case '101':
            $discount_rate=0.15;
            break;
case '102':
            $discount_rate=0.20 ;
            break;
case '103':
           $discount_rate=0.25;
           break;
default:
         $discount_rate=0.05;
         break;
}
$discount_amount=$price*$quantity*$discount_rate;
$net_bill_amount=($price*$quantity)-$discount_amount;
$sql="INSERT INTO orders (book_number,book_title,price,quantity,book_code,discount_rate,discount_amount,net_bill_amount)VALUES('$book_number','$book_title','$price','$quantity','$book_code','$discount_rate','$discount_amount','$net_bill_amount')";
if($conn->query($sql)==TRUE)
{
echo "order placed successfully!<br>";
echo "discount amount:$".number_format($discount_amount,2)."<br>";
echo "net bill amount:$".number_format($net_bill_amount,2)."<br>";
}
else
{
echo"error:".$sql. "<br>".$conn->error;
}
$conn->close();
?>
<?php
$servername="localhost";
$username="root";
$password="";
$dbname="bookstore";
$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error)
{
die("connection failed:".$conn->connect_error);
}
$book_number=$_POST['book_number'];
$book_title=$_POST['book_title'];
$price=$_POST['price'];
$quantity=$_POST['quantity'];
$book_code=$_POST['book_code'];
$sql="SELECT * FROM  orders ORDER BY order_date DESC";
$result=$conn->query($sql);
if($result->num_rows>0)
{
echo "<h2>order history</h2>";
echo "<table border='1'>";
echo "<tr><th>book number </th>
<th> book title </th>
<th> price </th>
<th> quantity </th>
<th> Discount amount </th>
<th> net bill amount </th>
<th> order date </th></tr>";
while($row=$result->fetch_assoc())
{
echo "<tr>";
echo "<td>".$row['book_number']."</td>";
echo "<td>".$row['book_title']."</td>";
echo "<td>$".$row['price']."</td>";
            echo "<td>".$row['quantity']."</td>;
            echo "<td>$".number_format($row['discount_amount'],2)."</td>";
echo "<td>$".number_format($row['net_bill_amount'],2)."</td>";
echo "<td>".$row['order_date']."</td>";
echo "</tr>";
}
echo"</table>";
}
else
{
echo "No Order Found.";
}
$conn->close();
?>
