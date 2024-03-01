<?php
require_once("assets/components/includes/msme.php");

// Function to fetch results based on given range
function displayResults($query, $range) {
    global $conn;
    $result = $conn->execute_query($query, $range);
    if ($result->num_rows) {
        while ($row = $result->fetch_object()) {
            echo "<li>{$row->sfm_code} | " . number_format($row->perc_value, 2) . "%</li>";
        }
    } else {
        echo "<li><em>You don't have " . ucfirst($range[0] == 0 ? "Low" : ($range[0] == 75 ? "Average" : "High")) . " Success Factor</em></li>";
    }
}

$query = "
SELECT
    sfms.*,
    (
        (
            SELECT
                SUM((responses.value / 5) * sfsms.weight)
            FROM
                responses
                left join sfsms on responses.sfsm_id = sfsms.id
            WHERE
                msme_id = 1
                and responses.sfm_id = sfms.id
        ) / sfms.weight
    ) * 100 AS perc_value
FROM
    sfms
HAVING 
    perc_value >= ? 
    AND perc_value <= ?
";

echo "<p>Low:</p>";
displayResults($query, [0, 74]);

echo "<p>Average:</p>";
displayResults($query, [75, 85]);

echo "<p>High:</p>";
displayResults($query, [86, 100]);
?>
