<?php
require_once "assets/components/includes/conn.php";

$query = $conn->query("
SELECT *
from assessment_monitoring am
    WHERE am.swot = 1
");
while ($row = $query->fetch_object()) {

?>
<tr>
    <td class="text-nowrap"><?= $row->msme_id ?></td>
    <?php
                    $get_main = $conn->query("
                    SELECT (
                        CASE
                            WHEN AVG(very_high) >= AVG(high)
                            AND AVG(very_high) >= AVG(average)
                            AND AVG(very_high) >= AVG(low)
                            AND AVG(very_high) >= AVG(very_low) THEN 5
                            WHEN AVG(high) >= AVG(average)
                            AND AVG(high) >= AVG(low)
                            AND AVG(high) >= AVG(very_low) THEN 4
                            WHEN AVG(average) >= AVG(low)
                            AND AVG(average) >= AVG(very_low) THEN 3
                            WHEN AVG(low) >= AVG(very_low) THEN 2
                            ELSE 1
                        END / 5
                    ) * s.weight AS score,
                    (
                        (
                            (
                                CASE
                                    WHEN AVG(very_high) >= AVG(high)
                                    AND AVG(very_high) >= AVG(average)
                                    AND AVG(very_high) >= AVG(low)
                                    AND AVG(very_high) >= AVG(very_low) THEN 5
                                    WHEN AVG(high) >= AVG(average)
                                    AND AVG(high) >= AVG(low)
                                    AND AVG(high) >= AVG(very_low) THEN 4
                                    WHEN AVG(average) >= AVG(low)
                                    AND AVG(average) >= AVG(very_low) THEN 3
                                    WHEN AVG(low) >= AVG(very_low) THEN 2
                                    ELSE 1
                                END / 5
                            ) * s.weight
                        ) / s.weight
                    ) * 100 AS percentage_score
                FROM
                    responses r
                    LEFT JOIN lookup_table lt ON r.`value` = lt.id
                    LEFT JOIN sfms s ON r.sfm_id = s.id
                WHERE
                    r.msme_id = $row->msme_id
                    AND r.assessment_type_id = 1
                GROUP BY
                    r.sfm_id;
                    ");
                    $tot_score = [];
                    $tot_score_percentage = [];
                    while ($get_main_row = $get_main->fetch_object()) {
?>
    <td class="text-nowrap"><?= number_format($get_main_row->score, 4) ?></td>
    <?php
    $tot_score[] = $get_main_row->score;
    $tot_score_percentage[] = $get_main_row->percentage_score;
                    }
                    ?>
                    <td class="text-nowrap"><?= number_format(array_sum($tot_score)/count($tot_score), 4) ?></td>
                    <td class="text-nowrap"><?= number_format(array_sum($tot_score_percentage)/count($tot_score_percentage), 2) ?></td>
</tr>
<?php
}
?>