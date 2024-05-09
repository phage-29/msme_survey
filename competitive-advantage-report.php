<?php
$page = "COMPETITIVE ADVANTAGE REPORT";
$protected = false;
require_once("assets/components/templates/header.php");
?>

<main>
  <div class="container">
    <section
      class="d-print-none section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-12 align-items-center justify-content-center" style="width: 100%">
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
                  <h5 class="card-title text-center pb-0 fs-4">MSME COMPETITIVE ADVANTAGE SCORECARD</h5>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="card border border-1">
                      <div class="card-header p-2" style="background-color:#eaeff8;">
                        Profile
                      </div>
                      <div class="card-body pt-3">
                        <p>Code:
                          <?= $get_msme->msme_code ?>
                        </p>
                        <p>Business Name:
                          <?= $get_msme->business_name ?>
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
                        <p>Industry Cluster:
                          <?= $get_msme->industry_cluster ?>
                        </p>
                        <p>EDT Level:
                          <?= $get_msme->edt_level ?>
                        </p>
                        <p>Asset Size:
                          <?= $get_msme->asset_size ?>
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="card border border-1">
                      <div class="card-header p-2" style="background-color:#eaeff8;">
                        Main Success Factors
                      </div>
                      <div class="card-body pt-3">
                        <div id="radarChart"></div>
                      </div>
                    </div>

                    <script>
                      <?php
                      // Execute SQL query to fetch data
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
                                      msme_id = ?
                                      and responses.sfm_id = sfms.id
                              ) / sfms.weight
                          ) * 100 AS perc_value
                      FROM
                          sfms
                      ";
                      $result = $conn->execute_query($query, [$msme_id]);

                      // Initialize arrays to store chart data
                      $chartData = [];
                      $categoryLabels = [];

                      // Fetch data and populate arrays
                      while ($row = $result->fetch_object()) {
                        $chartData[] = number_format($row->perc_value, 2);
                        $categoryLabels[] = $row->sfm_code;
                      }
                      ?>

                      var options = {
                        series: [{
                          name: 'Score',
                          data: [<?php echo implode(',', $chartData); ?>],
                        }],
                        chart: {
                          height: 350,
                          type: 'radar',
                        },
                        dataLabels: {
                          enabled: true,
                          formatter: function (val) {
                            return val + "%";
                          },
                        },
                        xaxis: {
                          categories: [<?php echo "'" . implode("','", $categoryLabels) . "'"; ?>],
                        }
                      };

                      var chart = new ApexCharts(document.querySelector("#radarChart"), options);
                      chart.render();
                    </script>
                  </div>
                  <div class="col-lg-12">
                    <div class="card border border-1">
                      <div class="card-header p-2" style="background-color:#eaeff8;">
                        Sub-Main Success Factors
                      </div>
                      <div class="card-body pt-3">
                        <div class="row">

                          <div class="dropdown d-lg-none">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                              aria-expanded="false">
                              Success Factor Sub Category
                            </button>
                            <ul class="dropdown-menu">
                              <div class="list-group border border-0" id="list-tab" role="tablist">
                                <?php
                                $query = $conn->query("SELECT * FROM sfms");
                                while ($row = $query->fetch_object()) {
                                  ?>
                                  <a class="border border-0 list-group-item list-group-item-action <?= $row->id == 2 ? 'active' : '' ?>"
                                    id="list-<?= $row->sfm_code ?>-list" data-bs-toggle="list"
                                    href="#list-<?= $row->sfm_code ?>" role="tab">
                                    <?= $row->sfm_code ?>
                                  </a>
                                  <?php
                                }
                                ?>
                              </div>
                            </ul>
                          </div>

                          <div class="col-2 d-none d-lg-block">
                            <div class="list-group" id="list-tab" role="tablist"
                              style="max-height: 300px; overflow-y:auto;">
                              <?php
                              $query = $conn->query("SELECT * FROM sfms");
                              while ($row = $query->fetch_object()) {
                                ?>
                                <a class="list-group-item list-group-item-action <?= $row->id == 2 ? 'active' : '' ?>"
                                  id="list-<?= $row->sfm_code ?>-list" data-bs-toggle="list"
                                  href="#list-<?= $row->sfm_code ?>" role="tab">
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
                                <div class="tab-pane fade <?= $row->id == 2 ? 'show active' : '' ?>"
                                  id="list-<?= $row->sfm_code ?>" role="tabpanel"
                                  aria-labelledby="list-<?= $row->sfm_code ?>-list">
                                  <div id="<?= $row->sfm_code ?>columnChart"></div>
                                  <script>
                                    <?php
                                    $query4 = $conn->query("
                                    SELECT
                                    sfms.*,
                                    (
                                    SELECT
                                    SUM(a.`value`) / SUM(5) * sfms.`weight`
                                    FROM
                                    responses a
                                    WHERE
                                    a.`msme_id` = $msme_id
                                    AND a.`assessment_type_id` = 1
                                    AND a.`sfm_id` = sfms.id
                                    ) AS total_value,
                                    (
                                    (
                                    SELECT
                                    SUM(a.`value`) / SUM(5) * sfms.`weight`
                                    FROM
                                    responses a
                                    WHERE
                                    a.`msme_id` = $msme_id
                                    AND a.`assessment_type_id` = 1
                                    AND a.`sfm_id` = sfms.id
                                    ) / sfms.weight
                                    ) * 100 as chart_data
                                    FROM
                                    sfms
                                    WHERE
                                    sfms.id = $row->id
                                    ");
                                    $get_avg = $query4->fetch_object();
                                    ?>
                                    var options = {
                                      series: [{
                                        data: [
                                          <?php
                                          $query2 = $conn->query("
                                          SELECT
                                          s.sfsm_code,
                                          (r.`value` / 5) * s.weight AS total_value,
                                          ((r.`value` / 5)) * 100 AS perc_value
                                          FROM 
                                          responses r
                                          LEFT JOIN 
                                          sfsms s ON r.sfsm_id = s.id 
                                          WHERE 
                                          s.sfm_id = $row->id AND r.msme_id = $msme_id");
                                          while ($row2 = $query2->fetch_object()) {
                                            echo number_format($row2->perc_value, 5, '.', '') . ",";
                                          }
                                          ?>
                                        ]
                                      }],
                                      chart: {
                                        type: 'bar',
                                        height: 350
                                      },
                                      title: {
                                        text: '<?= $row->sfm ?> Avg: <?= number_format($get_avg->chart_data, 2) ?>%',
                                      },
                                      tooltip: {
                                        x: {
                                          formatter: function (val) {
                                            return val
                                          }
                                        }
                                      },
                                      plotOptions: {
                                        bar: {
                                          borderRadius: 4,
                                          horizontal: true,
                                        }
                                      },
                                      dataLabels: {
                                        enabled: true,
                                        formatter: function (val) {
                                          return val + "%";
                                        },
                                        offsetY: 0,
                                        style: {
                                          fontSize: '12px',
                                          colors: ["#eee"]
                                        }
                                      },
                                      xaxis: {
                                        max: 100,
                                        categories: [<?php
                                        $query2 = $conn->query("SELECT
                                                      s.sfsm_code,
                                                      (r.`value` / 5) * s.weight AS total_value,
                                                      ((r.`value` / 5)) * 100 AS perc_value
                                                      FROM responses r
                                                      LEFT JOIN sfsms s ON r.sfsm_id = s.id WHERE s.sfm_id = $row->id AND r.msme_id = $msme_id");
                                        while ($row2 = $query2->fetch_object()) {
                                          echo "'" . $row2->sfsm_code . "',";
                                        }
                                        ?>],
                                      }
                                    };



                                    var chart = new ApexCharts(document.querySelector("#<?= $row->sfm_code ?>columnChart"), options);
                                    chart.render();
                                  </script>
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
                              echo "<li>" . $row->sfm . " <span class='float-end'>" . number_format($row->perc_value, 2) . "%</span></li>";
                            }
                          } else {
                            echo "<li><em>You don't have " . ucfirst($range[0] == 0 ? "Low" : ($range[0] == 75 ? "Average" : "High")) . " Success Factor</em></li>";
                          }
                        }
                        $query = "
                        SELECT
                            sfms.*,
                            ROUND((SUM(responses.value / 5 * sfsms.weight) / sfms.weight) * 100, 2) AS perc_value
                        FROM
                            sfms
                            LEFT JOIN responses ON responses.sfm_id = sfms.id
                            LEFT JOIN sfsms ON responses.sfsm_id = sfsms.id
                        WHERE
                            responses.msme_id = " . $msme_id . "
                        GROUP BY
                            sfms.id
                        HAVING 
                            perc_value BETWEEN ? AND ?;
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
                                displayResults($query, [0, 74]);
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
                                displayResults($query, [75, 85]);
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
                                displayResults($query, [86, 100]);
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
                                <?= $row->swot_category ?> <strong class="h6">
                                  <?= number_format($avg->value, 2) ?>%
                                </strong>
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
                          <table class="table table-bordered small">
                            <tbody>
                              <?php
                              $query2 = $conn->query("SELECT * FROM cfsms c WHERE c.cfm_id = $row->id");
                              while ($row2 = $query2->fetch_object()) {
                                $query3 = $conn->query("SELECT * FROM responses WHERE cfm_id=$row->id and cfsm_id=$row2->id and msme_id=$msme_id");
                                $get_query3 = $query3->fetch_object();
                                ?>
                                <tr>
                                  <td class=" small" scope="row">
                                    <?= $row2->cfsm ?>
                                  </td>
                                  <td id="colorIndicator<?= $row2->id ?>"
                                    class="<?= isset($get_query3->value) ? ($get_query3->value == 1 ? 'bg-success' : 'bg-danger') : 'bg-secondary-light' ?>"
                                    width="5%"></td>
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

                  <div class="mb-3 text-center">
                    <button class="btn btn-primary" onclick="window.print()">Print copy</button>
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
  <div class="d-print-block d-none" style="font-size: 1rem">
    <div class="row">
      <p class="text-center mb-3 h4"><strong>MSME COMPETITIVE ADVANTAGE SCORECARD</strong></p>
      <div class="col-6">
        <p class="h5"><strong>Profile</strong></p>
        <br>
        <div id="printQrcode"></div>
        <script type="text/javascript">
          var qrcode = new QRCode(document.getElementById("printQrcode"), {
            text: window.location.href,
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
          });
        </script>
        <br>
        <p class="small m-1">Code:
          <?= $get_msme->msme_code ?>
        </p>
        <p class="small m-1">Business Name:
          <?= $get_msme->business_name ?>
        </p>
        <p class="small m-1">Industry Cluster:
          <?= $get_msme->industry_cluster ?>
        </p>
        <p class="small m-1">EDT Level:
          <?= $get_msme->edt_level ?>
        </p>
        <p class="small m-1">Asset Size:
          <?= $get_msme->asset_size ?>
        </p>
      </div>
      <div class="col-6">
        <p class="h5"><strong>Main Success Factors</strong></p>
        <div id="printRadarChart"></div>

        <script>
          var options = {
            series: [{
              name: 'Score',
              data: [<?php echo implode(',', $chartData); ?>]
            }],
            chart: {
              width: 350,
              height: 350,
              type: 'radar',
              // toolbar: false,
            },
            title: {
              floating: true,
              offsetY: 330,
              align: 'center',
              style: {
                color: '#444'
              }
            },
            dataLabels: {
              enabled: true,
              formatter: function (val) {
                return val + "%";
              },
            },
            xaxis: {
              categories: [<?php echo "'" . implode("','", $categoryLabels) . "'"; ?>]
            }
          };

          var chart = new ApexCharts(document.querySelector("#printRadarChart"), options);
          chart.render();
        </script>
      </div>
      <hr>
      <hr>
      <div class="col-12">
        <p class="h5"><strong>Sub-Main Success Factors</strong></p>
        <?php
        $query = $conn->query("SELECT * FROM sfms");
        while ($row = $query->fetch_object()) {
          ?>
          <?php
          $query4 = $conn->query("
          SELECT sfms.*, (
          SELECT SUM(a.`value`) / SUM(5) * sfms.`weight`
          FROM responses a
          WHERE
          a.`msme_id` = $msme_id
          AND a.`assessment_type_id` = 1
          AND a.`sfm_id` = sfms.id
          ) AS total_value, (
          (
          SELECT SUM(a.`value`) / SUM(5) * sfms.`weight`
          FROM responses a
          WHERE
          a.`msme_id` = $msme_id
          AND a.`assessment_type_id` = 1
          AND a.`sfm_id` = sfms.id
          ) / sfms.weight
          ) * 100 as chart_data
          FROM sfms WHERE sfms.id = $row->id");
          $get_avg = $query4->fetch_object();
          ?>
          <strong>
            <?= $row->sfm ?>
            <span class="float-end">Average:
              <?= number_format($get_avg->chart_data, '2') ?>%
            </span>
          </strong>
          <table class="table table-striped border border-1 small">
            <thead>
              <tr>
                <th style="width:10vw" class="m-0 p-1 small">Code</th>
                <th class="m-0 p-1 small">Name</th>
                <th style="width:10vw" class="m-0 p-1 small">Percentage</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query2 = $conn->query("
              SELECT
              s.*,
              (r.`value` / 5) * s.weight AS total_value,
              ((r.`value` / 5)) * 100 AS perc_value
              FROM responses r
              LEFT JOIN sfsms s ON r.sfsm_id = s.id 
              WHERE s.sfm_id = $row->id AND r.msme_id = $msme_id");
              while ($row2 = $query2->fetch_object()) {
                ?>
                <tr>
                  <th class="m-0 pb-1 small">
                    <?= $row2->sfsm_code ?>
                  </th>
                  <td class="m-0 pb-1 small">
                    <?= $row2->sfsm ?>
                  </td>
                  <td class="m-0 pb-1 small text-end">
                    <?= number_format($row2->perc_value, 2) ?>%
                  </td>
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
      <hr>
      <hr>
      <div class="col-12">
        <p class="h5"><strong>Classification of Success Levels</strong></p>
        <?php
        $query = "
        SELECT
          sfms.*,
          ROUND((SUM(responses.value / 5 * sfsms.weight) / sfms.weight) * 100, 2) AS perc_value
        FROM
          sfms
          LEFT JOIN responses ON responses.sfm_id = sfms.id
          LEFT JOIN sfsms ON responses.sfsm_id = sfsms.id
        WHERE
          responses.msme_id = " . $msme_id . "
        GROUP BY
          sfms.id
        HAVING 
          perc_value BETWEEN ? AND ?;
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
                displayResults($query, [0, 74]);
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
                displayResults($query, [75, 85]);
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
                displayResults($query, [86, 100]);
                ?>
              </ul>
            </div>
          </div>
        </div>
        <hr>
        <hr>
        <div class="col-12 row">
          <p class="h5"><strong>SWOT Analysis</strong></p>
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
            <div class="card col-6">
              <strong class="card-header text-muted">
                <?= $row->swot_category[0] ?> |
                <?= $row->swot_category ?> <?= number_format($avg->value, 2) ?>%
              </strong>
              <ul class="card-body">
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
            <?php
          }
          ?>
        </div>
        <hr>
        <hr>
        <div class="col-12">
          <p class="h5"><strong>Competitive Features</strong></p>
          <?php
          $query = $conn->query("SELECT * FROM cfms");
          while ($row = $query->fetch_object()) {
            ?>
            <p>
              <?= $row->cfm ?>
            </p>
            <table class="table table-bordered small">
              <tbody>
                <?php
                $query2 = $conn->query("SELECT * FROM cfsms c WHERE c.cfm_id = $row->id");
                while ($row2 = $query2->fetch_object()) {
                  $query3 = $conn->query("SELECT * FROM responses WHERE cfm_id=$row->id and cfsm_id=$row2->id and msme_id=$msme_id");
                  $get_query3 = $query3->fetch_object();
                  ?>
                  <tr>
                    <td class=" small" scope="row">
                      <?= $row2->cfsm ?>
                    </td>
                    <td id="colorIndicator<?= $row2->id ?>"
                      style="color: <?= isset($get_query3->value) ? ($get_query3->value == 1 ? '#198754' : '#dc3545') : '#e2e3e5' ?>"
                      width="5%">
                      <?= isset($get_query3->value) ? ($get_query3->value == 1 ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>' : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/></svg>') : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4m.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/></svg>' ?>
                    </td>
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
        <hr>
        <hr>
        <div class="col-12">
          <p class="h5"><strong>Summary of Findings</strong></p>
          ...
          <hr>
        </div>
      </div>
    </div>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/footer.php");
?>