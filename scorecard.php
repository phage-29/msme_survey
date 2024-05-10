<?php
$page = "COMPETITIVE ADVANTAGE REPORT";
$protected = false;
require_once("assets/components/templates/header.php");
?>

<main>
    <div class="px-5">
        <section class="d-print-none section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="px-5">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 align-items-center justify-content-center" style="width: 100%">
                        <div class="d-flex justify-content-center py-4">
                            <a href="index.php" class="logo d-flex align-items-center w-auto">
                                <img src="assets/img/logo.png" alt="">
                                <span class="d-none d-lg-block">
                                    <?= website ?>
                                </span>
                            </a>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">MSME COMPETITIVE ADVANTAGE REPORT</h5>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8 row">
                                        <div class="col-lg-6">
                                            <div class="card border border-1">
                                            <div class="card-header p-2" style="background-color:#eaeff8;">
                                                    <strong class="h4">Profile</strong>
                                                </div>
                                                <div class="card-body pt-3">
                                                    <p><strong>Code:</strong>
                                                        <?= $get_msme->msme_code ?>
                                                    </p>
                                                    <div id="qrcode"></div>
                                                    <script type="text/javascript">
                                                        var qrcode = new QRCode(document.getElementById("qrcode"), {
                                                            text: window.location.href,
                                                            width: 128,
                                                            height: 128,
                                                            colorDark: "#000000",
                                                            colorLight: "#ffffff",
                                                            correctLevel: QRCode.CorrectLevel.H
                                                        });
                                                    </script>
                                                    <br>
                                                    <p><strong>Business Name:</strong>
                                                        <?= $get_msme->business_name ?>
                                                    </p>
                                                    <p><strong>Province:</strong>
                                                        <?= $get_msme->province ?>
                                                    </p>
                                                    <p><strong>Industry Cluster:</strong>
                                                        <?= $get_msme->industry_cluster ?>
                                                    </p>
                                                    <p><strong>Major Business Activity:</strong>
                                                        <?= $get_msme->major_business_activity ?>
                                                    </p>
                                                    <p><strong>EDT Level:</strong>
                                                        <?= $get_msme->edt_level ?>
                                                    </p>
                                                    <p><strong>Asset Size:</strong>
                                                        <?= $get_msme->asset_size ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card border border-1">
                                            <div class="card-header p-2" style="background-color:#eaeff8;">
                                                    <strong class="h4">Main Success Factors</strong>
                                                </div>
                                                <div class="card-body pt-3">
                                                    <div id="radarChart" style="width: 100%"></div>
                                                </div>
                                            </div>

                                            <script>
                                                <?php
                                                // Execute SQL query to fetch data
                                                $query = "
                                                SELECT
                                                    s.*,
                                                    CASE
                                                        WHEN AVG(very_high) >= AVG(high)
                                                        AND AVG(very_high) >= AVG(average)
                                                        AND AVG(very_high) >= AVG(low)
                                                        AND AVG(very_high) >= AVG(very_low) THEN 'VERY_HIGH'
                                                        WHEN AVG(high) >= AVG(average)
                                                        AND AVG(high) >= AVG(low)
                                                        AND AVG(high) >= AVG(very_low) THEN 'HIGH'
                                                        WHEN AVG(average) >= AVG(low)
                                                        AND AVG(average) >= AVG(very_low) THEN 'AVERAGE'
                                                        WHEN AVG(low) >= AVG(very_low) THEN 'LOW'
                                                        ELSE 'VERY_LOW'
                                                    END AS fuzzy_value,
                                                    GREATEST(
                                                        AVG(very_high), AVG(high), AVG(average), AVG(low), AVG(very_low)
                                                    ) AS max_membership,
                                                    s.weight as assigned_weight,
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
                                                    r.msme_id = ?
                                                    AND assessment_type_id = 1
                                                GROUP BY
                                                    r.sfm_id
                                                ";
                                                $result = $conn->execute_query($query, [$msme_id]);

                                                // Initialize arrays to store chart data
                                                $chartData = [];
                                                $categoryLabels = [];

                                                // Fetch data and populate arrays
                                                while ($row = $result->fetch_object()) {
                                                    $chartData[] = number_format($row->percentage_score, 2);
                                                    $categoryLabels[] = $row->sfm_code;
                                                }
                                                ?>

                                                var options = {
                                                    series: [{
                                                        name: 'Score',
                                                        data: [<?php echo implode(',', $chartData); ?>],
                                                    }],
                                                    chart: {
                                                        height: 430,
                                                        type: 'radar',
                                                    },
                                                    title: {
                                                        text: 'OVERALL SCORE: <?= number_format(array_sum($chartData) / count($chartData), 2) ?>%',
                                                        align: 'center'
                                                    },
                                                    dataLabels: {
                                                        enabled: true,
                                                        formatter: function(val) {
                                                            return val + "%";
                                                        },
                                                    },
                                                    xaxis: {
                                                        categories: [
                                                            <?php echo "'" . implode("','", $categoryLabels) . "'"; ?>
                                                        ],
                                                    }
                                                };

                                                var chart = new ApexCharts(document.querySelector("#radarChart"), options);
                                                chart.render();
                                            </script>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="card border border-1">
                                            <div class="card-header p-2" style="background-color:#eaeff8;">
                                                    <strong class="h4">Sub-Main Success Factors</strong>
                                                </div>
                                                <div class="card-body pt-3">
                                                    <div class="row">

                                                        <div class="dropdown d-lg-none">
                                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Success Factor Sub Category
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <div class="list-group border border-0" id="list-tab" role="tablist">
                                                                    <?php
                                                                    $query = $conn->query("SELECT * FROM sfms");
                                                                    while ($row = $query->fetch_object()) {
                                                                    ?>
                                                                        <a class="border border-0 list-group-item list-group-item-action <?= $row->id == 2 ? 'active' : '' ?>" id="list-<?= $row->sfm_code ?>-list" data-bs-toggle="list" href="#list-<?= $row->sfm_code ?>" role="tab">
                                                                            <?= $row->sfm_code ?>
                                                                        </a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </ul>
                                                        </div>

                                                        <div class="col-2 d-none d-lg-block">
                                                            <div class="list-group" id="list-tab" role="tablist" style="max-height: 300px; overflow-y:auto;">
                                                                <?php
                                                                $query = $conn->query("SELECT * FROM sfms");
                                                                while ($row = $query->fetch_object()) {
                                                                ?>
                                                                    <a class="list-group-item list-group-item-action <?= $row->id == 2 ? 'active' : '' ?>" id="list-<?= $row->sfm_code ?>-list" data-bs-toggle="list" href="#list-<?= $row->sfm_code ?>" role="tab">
                                                                        <?= $row->sfm_code ?>
                                                                    </a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-10">
                                                            <div class="tab-content" id="nav-tabContent">
                                                                <?php
                                                                $query = $conn->query("SELECT * FROM sfms");
                                                                while ($row = $query->fetch_object()) {
                                                                ?>
                                                                    <div class="tab-pane fade <?= $row->id == 2 ? 'show active' : '' ?>" id="list-<?= $row->sfm_code ?>" role="tabpanel" aria-labelledby="list-<?= $row->sfm_code ?>-list">

                                                                        <?php
                                                                        $get_main = "
                                                                  SELECT
                                                                  s.*,
                                                                  CASE
                                                                      WHEN AVG(very_high) >= AVG(high)
                                                                      AND AVG(very_high) >= AVG(average)
                                                                      AND AVG(very_high) >= AVG(low)
                                                                      AND AVG(very_high) >= AVG(very_low) THEN 'VERY HIGH'
                                                                      WHEN AVG(high) >= AVG(average)
                                                                      AND AVG(high) >= AVG(low)
                                                                      AND AVG(high) >= AVG(very_low) THEN 'HIGH'
                                                                      WHEN AVG(average) >= AVG(low)
                                                                      AND AVG(average) >= AVG(very_low) THEN 'AVERAGE'
                                                                      WHEN AVG(low) >= AVG(very_low) THEN 'LOW'
                                                                      ELSE 'VERY LOW'
                                                                  END AS fuzzy_value,
                                                                  GREATEST(
                                                                      AVG(very_high),
                                                                      AVG(high),
                                                                      AVG(average),
                                                                      AVG(low),
                                                                      AVG(very_low)
                                                                  ) AS max_membership,
                                                                  s.weight as assigned_weight,
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
                                                                  r.msme_id = ?
                                                                  AND s.id = ?
                                                                  AND assessment_type_id = 1
                                                              GROUP BY
                                                                  r.sfm_id;
                                                                  ";
                                                                        $get_main_result = $conn->execute_query($get_main, [$msme_id, $row->id]);
                                                                        while ($get_main_row = $get_main_result->fetch_object()) {
                                                                        ?>
                                                                            <h5><b><?= $row->sfm ?> Score:
                                                                                    <?= number_format($get_main_row->percentage_score, 2) ?>%</b>
                                                                            </h5>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <hr>
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <th>
                                                                                    <?= $row->sfm ?>
                                                                                </th>
                                                                                <th class="text-center">
                                                                                    Evaluation
                                                                                </th>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php
                                                                                $get_submain = "
                                                                      SELECT *
                                                                      FROM
                                                                          responses r
                                                                          LEFT JOIN sfsms ss ON r.sfsm_id = ss.id
                                                                          LEFT JOIN lookup_table lt ON r.`value` = lt.id
                                                                      WHERE
                                                                          r.assessment_type_id = 1
                                                                          AND r.msme_id = ?
                                                                          AND r.sfm_id = ?;
                                                                      ";

                                                                                $get_submain_result = $conn->execute_query($get_submain, [$msme_id, $row->id]);
                                                                                while ($get_submain_row = $get_submain_result->fetch_object()) {
                                                                                ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <?= $get_submain_row->sfsm ?>
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            <?= $get_submain_row->selection ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card border border-1">
                                                <div class="card-header p-2" style="background-color:#eaeff8;">
                                                    <strong class="h4">Classification of Success Levels</strong>
                                                </div>
                                                <div class="card-body pt-3 row small text-center">
                                                    <?php
                                                    function displayResults($query, $range)
                                                    {
                                                        global $conn;
                                                        $result = $conn->execute_query($query, $range);
                                                        if ($result->num_rows) {
                                                            while ($row = $result->fetch_object()) {
                                                                echo "<li class='border border-0 border-bottom'>" . $row->sfm . " <span class='float-end'>" . number_format($row->percentage_score, 2) . "%</span></li>";
                                                            }
                                                        } else {
                                                            echo "<li class='border border-0 border-bottom'><em>You do not have " . ucfirst($range[0] == 0 ? "Low" : ($range[0] == 75 ? "Average" : "High")) . " Success Factor</em></li>";
                                                        }
                                                    }
                                                    $query = "
                                                                    SELECT
                                                s.*,
                                                CASE
                                                    WHEN AVG(very_high) >= AVG(high)
                                                    AND AVG(very_high) >= AVG(average)
                                                    AND AVG(very_high) >= AVG(low)
                                                    AND AVG(very_high) >= AVG(very_low) THEN 'VERY_HIGH'
                                                    WHEN AVG(high) >= AVG(average)
                                                    AND AVG(high) >= AVG(low)
                                                    AND AVG(high) >= AVG(very_low) THEN 'HIGH'
                                                    WHEN AVG(average) >= AVG(low)
                                                    AND AVG(average) >= AVG(very_low) THEN 'AVERAGE'
                                                    WHEN AVG(low) >= AVG(very_low) THEN 'LOW'
                                                    ELSE 'VERY_LOW'
                                                END AS fuzzy_value,
                                                GREATEST(
                                                    AVG(very_high),
                                                    AVG(high),
                                                    AVG(average),
                                                    AVG(low),
                                                    AVG(very_low)
                                                ) AS max_membership,
                                                s.weight as assigned_weight,
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
                                                r.msme_id = " . $msme_id . "
                                                AND assessment_type_id = 1
                                            GROUP BY
                                                r.sfm_id
                                            HAVING
                                                percentage_score BETWEEN ? AND ?
                                                                    ";
                                                    ?>
                                                    <div class="col-lg-4">
                                                        <div class="card border border-1">
                                                            <div class="card-header">
                                                                Low
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="list-group list-group-flush text-start">
                                                                    <?php
                                                                    displayResults($query, [1, 50]);
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="card border border-1">
                                                            <div class="card-header">
                                                                Average
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="list-group list-group-flush text-start">
                                                                    <?php
                                                                    displayResults($query, [51, 80]);
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="card border border-1">
                                                            <div class="card-header">
                                                                High
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="list-group list-group-flush text-start">
                                                                    <?php
                                                                    displayResults($query, [81, 100]);
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="card border border-1">
                                                <div class="card-header p-2" style="background-color:#eaeff8;">
                                                    <strong class="h4">
                                                        SWOT Analysis
                                                    </strong>
                                                </div>
                                                <div class="card-body pt-3 row small">
                                                    <?php
                                                    $query = "SELECT distinct(`swot_category`) from `swots`";
                                                    $result = $conn->execute_query($query);
                                                    while ($row = $result->fetch_object()) {
                                                        $avg = $conn->query("SELECT
                                                        (COUNT(r.id) / COUNT(s.id)) * 100 as `value`
                                                    FROM
                                                        swots s
                                                        left join (
                                                            SELECT
                                                                *
                                                            from
                                                                responses r
                                                            where
                                                                r.msme_id = " . $msme_id . "
                                                        ) r ON s.id = r.swot_id
                                                    WHERE s.swot_category = '" . $row->swot_category . "'")->fetch_object();
                                                    ?>
                                                        <div class="col-md-6">
                                                            <div class="card border border-1">
                                                                <div class="card-header p-1">
                                                                    <strong class="h4">
                                                                        <?= $row->swot_category[0] ?> |
                                                                    </strong>
                                                                    <?= $row->swot_category ?>
                                                                </div>
                                                                <div class="card-body pt-3" style="height: 300px;overflow-y: auto; font-size: 0.75em;">
                                                                    <ul>
                                                                        <?php
                                                                        $query2 = "SELECT * FROM responses r LEFT JOIN swots ON r.swot_id = swots.id WHERE r.swot_id IS NOT NULL AND r.msme_id = ? AND swots.swot_category = ?";
                                                                        $result2 = $conn->execute_query($query2, [$msme_id, $row->swot_category]);
                                                                        while ($row2 = $result2->fetch_object()) {
                                                                        ?>
                                                                            <li class="mt-3">
                                                                                <?= $row2->swot ?>
                                                                            </li>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 row">
                                        <div class="col-md-12">
                                            <div class="card border border-1">
                                                <div class="card-header p-2" style="background-color:#eaeff8;">
                                                    <strong class="h4">
                                                        Competitive Features
                                                    </strong>
                                                </div>
                                                <div class="card-body pt-3 small">
                                                    <?php
                                                    $query = $conn->query("SELECT * FROM cfms");
                                                    while ($row = $query->fetch_object()) {
                                                    ?>
                                                        <p>
                                                            <?= $row->cfm ?>
                                                        </p>
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <?php
                                                                $query2 = $conn->query("SELECT * FROM cfsms c WHERE c.cfm_id = $row->id");
                                                                while ($row2 = $query2->fetch_object()) {
                                                                    $query3 = $conn->query("SELECT * FROM responses WHERE cfm_id=$row->id and cfsm_id=$row2->id and msme_id=$msme_id");
                                                                    $get_query3 = $query3->fetch_object();
                                                                ?>
                                                                    <tr>
                                                                        <td class="" scope="row">
                                                                            <?= $row2->cfsm ?>
                                                                        </td>
                                                                        <td id="colorIndicator<?= $row2->id ?>" class="<?= isset($get_query3->value) ? ($get_query3->value == 1 ? 'bg-success' : 'bg-danger') : 'bg-secondary-light' ?>" width="5%"></td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                            <div class="card border border-1">
                                                <div class="card-header p-2" style="background-color:#eaeff8;">
                                                    <strong class="h4">
                                                        Summary Findings
                                                    </strong>
                                                </div>
                                                <div class="card-body pt-3 small">
                                                <p class="lh-base">
                                                    [Business Name] with Code: [MSME Code] has a
                                                </p>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="credits text-center small">
                        Designed by <a href="#Phage">Phage</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/footer.php");
?>