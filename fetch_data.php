<?php
require_once "assets/components/includes/conn.php";

$query = $conn->query("SELECT
                            m.id,
                                m.business_name,
                                p.province,
                                `as`.asset_size,
                                `el`.edt_level,
                                `ic`.industry_cluster,
                                `mba`.major_business_activity
                            FROM
                                msmes m
                                LEFT JOIN provinces p ON m.province_id = p.id
                                LEFT JOIN asset_sizes `as` ON m.asset_size_id = `as`.id
                                LEFT JOIN edt_levels `el` ON m.edt_level_id = `el`.id
                                LEFT JOIN industry_clusters `ic` ON m.industry_cluster_id = `ic`.id
                                LEFT JOIN major_business_activities `mba` ON m.major_business_activity_id = `mba`.id
                                LEFT JOIN assessment_monitoring am ON m.id = am.msme_id
                            WHERE
                                am.scorecard = 1");
while ($row = $query->fetch_object()) {

?>
    <tr>
        <td class="text-nowrap"><a href="?msme_id=<?= $row->id ?>"><?= $row->business_name ?></a></td>
        <td class="text-nowrap"><?= $row->province ?></td>
        <td class="text-nowrap"><?= $row->asset_size ?></td>
        <td class="text-nowrap"><?= $row->edt_level ?></td>
        <td class="text-nowrap"><?= $row->industry_cluster ?></td>
        <td class="text-nowrap"><?= $row->major_business_activity ?></td>
        <?php
        $query2 = $conn->query("SELECT
                                    mr2.msme_id,
                                    s2.*,
                                    GREATEST (
                                        AVG(mr2.very_high),
                                        AVG(mr2.high),
                                        AVG(mr2.average),
                                        AVG(mr2.low),
                                        AVG(mr2.very_low)
                                    ) AS highest_average
                                FROM
                                    sfms s2
                                    LEFT JOIN (
                                        SELECT
                                            r3.msme_id,
                                            r3.sfm_id,
                                            r3.sfsm_id,
                                            lt3.selection,
                                            lt3.very_high,
                                            lt3.high,
                                            lt3.average,
                                            lt3.low,
                                            lt3.very_low
                                        FROM
                                            responses r3
                                            LEFT JOIN lookup_table lt3 ON r3.`value` = lt3.id
                                        WHERE
                                            assessment_type_id = 1
                                            AND msme_id = $row->id
                                    ) mr2 ON s2.id = mr2.sfm_id
                                GROUP BY
                                    s2.id;");
        $num = 0;
        $total = 0;
        while ($row2 = $query2->fetch_object()) {
        ?>
            <td class="text-nowrap"><?= number_format($row2->highest_average, 4) ?></td>
        <?php
            $num++;
            $total = $total + $row2->highest_average;
        }
        ?>
        <td class="text-nowrap"><?= number_format($total / $num, 4) ?></td>
        <td class="text-nowrap"><?= number_format(($total / $num) * 100, 2) ?>%</td>
    </tr>
<?php
}
?>