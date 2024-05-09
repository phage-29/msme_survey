<?php
// Define the levels
$levels = array("Very high", "High", "Average", "Low", "Very low");

// Generate all possible combinations
$combinations = cartesianProduct($levels, 7);

// Function to compute Cartesian product
function cartesianProduct($array, $repeat) {
    if ($repeat == 0) {
        return array(array());
    }
    $previous = cartesianProduct($array, $repeat - 1);
    $result = array();
    foreach ($previous as $p) {
        foreach ($array as $a) {
            $result[] = array_merge($p, array($a));
        }
    }
    return $result;
}

// Print each combination
foreach ($combinations as $combo) {
    echo "<table style='border: 1px solid black'>";
    echo "<tr><th>". implode("</th><th>", $combo) . "</th></tr>";
    echo "</table>";
}
?>
