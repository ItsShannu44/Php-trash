<!DOCTYPE html>
<html>
<head><title>Word Frequency Counter</title></head>
<body>
<h2>Word Frequency Counter</h2>
<form method="post">
    <textarea name="inputText" placeholder="Enter your text here"><?= htmlspecialchars($_POST['inputText'] ?? '') ?></textarea><br><br>
    <input type="submit" name="submit" value="Submit">
    <input type="submit" name="sort_asc" value="Sort Ascending">
    <input type="submit" name="sort_desc" value="Sort Descending">
</form>

<?php
if (!empty($_POST['inputText'])) {
    $text = strtolower($_POST['inputText']);
    $words = str_word_count($text, 1);
    $counts = array_count_values($words);
    $original = $counts;

    if (isset($_POST['sort_asc'])) asort($counts);
    if (isset($_POST['sort_desc'])) arsort($counts);

    echo "<h3>Input:</h3><p>" . htmlspecialchars($_POST['inputText']) . "</p>";
    echo "<h3>Frequency:</h3><ul>";
    foreach ($counts as $word => $count)
        echo "<li>$word : $count " . ($count == 1 ? "time" : "times") . "</li>";
    echo "</ul>";

    $max = max($original);
    $min = min($original);
    $most = array_keys($original, $max);
    $least = array_keys($original, $min);

    echo "<p><strong>Most used word(s):</strong> " . implode(', ', array_map(fn($w) => "$w ($max times)", $most)) . "</p>";
    echo "<p><strong>Least used word(s):</strong> " . implode(', ', array_map(fn($w) => "$w ($min times)", $least)) . "</p>";
}
?>
</body>
</html>
