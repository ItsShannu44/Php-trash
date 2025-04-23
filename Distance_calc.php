calc.html
<html>
    <head>
        <title>Distance calculator</title>
</head>
</body>
<h2>Distance calculator</h2>
<form action="distance_calculator.php" method="post">
    <h3>Distance 1:</h3>
    <label for="feet1">Feet:</label>
    <input type="number"id="feet1"name="feet1" required><br><br>
    <label for="inches1">Inches:</label>
    <input type="number"id="inches1"name="inches1" required><br><br>
    <h3>Distance 2:</h3>
    <label for="feet2">Feet:</label>
    <input type="number"id="feet2"name="feet2" required><br><br>
    <label for="inches2">Inches:</label>
    <input type="number"id="inches2"name="inches2" required><br><br>
     <input type="submit"value="Calculate">
</form>
</body>
</html>

distance_calculator.php
<?php
class DistanceCalculator {
    public function addDistance($feet1, $inches1, $feet2, $inches2) {
        $totalFeet = $feet1 + $feet2;
        $totalInches = $inches1 + $inches2;
        if ($totalInches >= 12) {
            $totalFeet += floor($totalInches / 12);
            $totalInches %= 12;
        }
        return array($totalFeet, $totalInches);
    }
    public function findDifference($feet1, $inches1, $feet2, $inches2) {
        $totalFeet1 = $feet1 + $inches1 / 12;
        $totalFeet2 = $feet2 + $inches2 / 12;
        $difference = abs($totalFeet1 - $totalFeet2);
        $differenceFeet = floor($difference);
        $differenceInches = ($difference - $differenceFeet) * 12;
        return array($differenceFeet, $differenceInches);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feet1 = $_POST["feet1"];
    $inches1 = $_POST["inches1"];
    $feet2 = $_POST["feet2"];
    $inches2 = $_POST["inches2"];
    $calculator = new DistanceCalculator();
    $sum_result = $calculator->addDistance($feet1,$inches1,$feet2,$inches2);
    $difference_result = $calculator->findDifference($feet1,$inches1,$feet2,$inches2);
    echo "Sum: " . $sum_result[0] . " feet and " . $sum_result[1] . " inches<br>";
    echo "Difference: " . $difference_result[0] . " feet and " . $difference_result[1] . " inches<br>";
}
?>
