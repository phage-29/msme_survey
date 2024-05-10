<?php
require_once "assets/components/includes/conn.php";

$query = $conn->query("
SELECT *
from assessment_monitoring am
    LEFT JOIN (
        SELECT m.id as msmeID, m.*, p.province, ic.industry_cluster, mba.major_business_activity, el.edt_level, asz.asset_size
        FROM
            msmes m
            LEFT JOIN provinces p ON m.province_id = p.id
            LEFT JOIN industry_clusters ic ON m.industry_cluster_id = ic.id
            LEFT JOIN major_business_activities mba ON m.major_business_activity_id = mba.id
            LEFT JOIN edt_levels el ON m.edt_level_id = el.id
            LEFT JOIN asset_sizes asz ON m.asset_size_id = asz.id
    ) m on am.msme_id = m.id
    WHERE am.swot = 1
");
while ($row = $query->fetch_object()) {

?>
<tr>
    <td class="text-nowrap"><?= $row->msme_code ?></td>
    <td class="text-nowrap"><?= $row->province ?></td>
    <td class="text-nowrap"><a href="scorecard.php?ref=<?= encryptID($row->id,secret_key) ?>" target="blank_"><?= $row->business_name ?></a></td>
    <td class="text-nowrap"><?= $row->first_name ?> <?= $row->middle_name ?> <?= $row->last_name ?></td>
    <td class="text-nowrap"><?= $row->sex ?></td>
    <td class="text-nowrap"><?= $row->age ?></td>
    <td class="text-nowrap"><?= $row->phone ?></td>
    <td class="text-nowrap"><?= $row->email ?></td>
    <td class="text-nowrap"><?= $row->industry_cluster ?></td>
    <td class="text-nowrap"><?= $row->asset_size ?></td>
    <td class="text-nowrap"><?= $row->edt_level ?></td>
    <td class="text-nowrap"><?= $row->major_business_activity ?></td>
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
    END AS scale_rating,
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
                    r.msme_id = $row->msmeID
                    AND r.assessment_type_id = 1
                GROUP BY
                    r.sfm_id;
                    ");
                    $tot_score = [];
                    $tot_score_percentage = [];
                    while ($get_main_row = $get_main->fetch_object()) {
?>
    <td class="text-nowrap"><?= number_format($get_main_row->score, 4) ?></td>
    <td class="text-nowrap"><?= $get_main_row->scale_rating ?></td>
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