<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Matrix Operations</title>
</head>
<body>
<?php
$m = 0;
$n = 0;
if(isset($_REQUEST["M"]) && isset($_REQUEST["N"])) {
$m = $_REQUEST["M"];
$n = $_REQUEST["N"];
session_unset();
$_SESSION["m"] = $m;
$_SESSION["n"] = $n;
}
if(isset($_SESSION["m"]) && isset($_SESSION["n"])) {
$m = $_SESSION["m"];
$n = $_SESSION["n"];
}
?>
<form method="post">
Enter the number of rows: <input type="number" name="M" value="<?= $m ?>"><br><br>
Enter the number of columns: <input type="number" name="N" value="<?= $n
?>"><br><br>
<input type="submit" name="createMatrixBtn" value="Create Matrix">
</form>
<?php
function CreateMatrix($strTitle, $arName) {
$m = $_SESSION["m"];
$n = $_SESSION["n"];
echo "<h3>$strTitle</h3>";
echo "<table border=\"2\">";
for ($i = 0; $i < $m; $i++) {
echo "<tr>";
for ($j = 0; $j < $n; $j++) {
echo "<td>";
?>
<input type="number" name="<?= $arName ?>[]">
<?php
echo "</td>";
}
echo "</tr>";
}
echo "</table>";
}
function showMatButton() {
echo "<br>";
echo "<input type=\"submit\" name=\"addMat\" value=\"Add Matrice\">";
echo "&nbsp; &nbsp;";
echo "<input type=\"submit\" name=\"mulMat\" value=\"Multiply Matrice\">";
}
function GenerateMatrix($strTitle, $arName, $matName, $a) {
$m = $_SESSION["m"];
$n = $_SESSION["n"];
echo "<h3>$strTitle</h3>";
echo "<table border=\"2\">";
$k = 0;
for ($i = 0; $i < $m; $i++) {
echo "<tr>";
for ($j = 0; $j < $n; $j++) {
echo "<td>";
$$matName[$i][$j] = $a[$k];
$k++;
?>
<input type="number" name="<?= $arName ?>[]" value="<?= $$matName[$i][$j]
?>">
<?php
echo "</td>";
}
echo "</tr>";
}
echo "</table>";
$_SESSION[$matName] = $$matName;
}
if(isset($_REQUEST["createMatrixBtn"])) {
echo "<form method=\"post\">";
CreateMatrix("Matrix A", "a");
CreateMatrix("Matrix B", "b");
showMatButton();
echo "</form>";
}
if(isset($_REQUEST["addMat"])) {
echo "<form method=\"post\">";
$a = $_REQUEST["a"];
$b = $_REQUEST["b"];
GenerateMatrix("Matrix A", "a", "ma", $a);
GenerateMatrix("Matrix B", "b", "mb", $b);
$ma = $_SESSION["ma"];
$mb = $_SESSION["mb"];
echo "<h3>Result Matrix </h3>";
echo "<table border=\"1\" width=\"20%\">";
for ($i = 0; $i < $m; $i++) {
echo "<tr>";
for ($j = 0; $j < $n; $j++) {
echo "<td align=\"center\">";
$mc[$i][$j] = $ma[$i][$j] + $mb[$i][$j];
echo $mc[$i][$j];
echo "</td>";
}
echo "</tr>";
}
echo "</table>";
echo "</form>";
}
if(isset($_REQUEST["mulMat"])) {
if ($m != $n) {
echo "<h3>wrong dimension, cannot multiply</h3>";
} else {
echo "<form method=\"post\">";
$a = $_REQUEST["a"];
$b = $_REQUEST["b"];
GenerateMatrix("Matrix A", "a", "ma", $a);
GenerateMatrix("Matrix B", "b", "mb", $b);
$ma = $_SESSION["ma"];
$mb = $_SESSION["mb"];
echo "<h3>Product Matrix </h3>";
echo "<table border=\"1\" width=\"20%\">";
for ($i = 0; $i < $m; $i++) {
echo "<tr>";
for ($j = 0; $j < $n; $j++) {
echo "<td align=\"center\">";
$mc[$i][$j] = 0;
for ($k = 0; $k < $n; $k++) {
$mc[$i][$j] += $ma[$i][$k] * $mb[$k][$j];
}
echo $mc[$i][$j];
echo "</td>";
}
echo "</tr>";
}
echo "</table>";
echo "</form>";
}
}
?>
</body>
</html>
