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
              <a href="dashboard.php" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
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
                      $query = "SELECT sfms.*, (SELECT SUM(a.`value`) / SUM(5) * sfms.`weight` FROM responses a WHERE a.`msme_id` = $msme_id AND a.`assessment_type_id` = 1 AND a.`sfm_id` = sfms.id) AS total_value, ((SELECT SUM(a.`value`) / SUM(5) * sfms.`weight` FROM responses a WHERE a.`msme_id` = $msme_id AND a.`assessment_type_id` = 1 AND a.`sfm_id` = sfms.id) / sfms.weight) * 100 AS chart_data FROM sfms";
                      $result = $conn->execute_query($query);

                      // Initialize arrays to store chart data
                      $chartData = [];
                      $categoryLabels = [];

                      // Fetch data and populate arrays
                      while ($row = $result->fetch_object()) {
                        $chartData[] = number_format($row->chart_data, 2);
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
(r.`value` / 5) AS total_value,
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
(r.`value` / 5) AS total_value,
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

                  <h5 class="text-center pb-0 fs-4">SWOT Analysis</h5>
                  <?php
                  $query = "SELECT distinct(`swot_category`) from `swots`";
                  $result = $conn->execute_query($query);
                  while ($row = $result->fetch_object()) {
                    ?>
                    <div class="col-md-6">
                      <div class="card border border-1">
                        <div class="card-header p-2" style="background-color:#eaeff8;">
                          <strong class="h4">
                            <?= $row->swot_category[0] ?> |
                          </strong>
                          <?= $row->swot_category ?>
                        </div>
                        <div class="card-body pt-3" style="height: 300px;overflow-y: auto;">
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

                <div class="mb-3 text-center">
                  <button class="btn btn-primary" onclick="window.print()">Print copy</button>
                </div>
              </div>
            </div>

            <div class="credits text-center">
              Designed by <a href="#Phage">Phage</a>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
  <div class="d-print-block d-none" style="font-size: 1rem">
    <div class="row">
      <p class="text-center mb-3 h4">MSME COMPETITIVE ADVANTAGE SCORECARD</p>
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
              data: [
                <?php
                $query = "
SELECT 
sfms.*,
SUM(a.`value`) / SUM(5) * sfms.`weight` AS total_value,
(SUM(a.`value`) / SUM(5) * sfms.`weight` / sfms.weight) * 100 AS chart_data
FROM 
sfms
LEFT JOIN 
responses a ON a.`sfm_id` = sfms.id AND a.`msme_id` = $msme_id AND a.`assessment_type_id` = 1
GROUP BY 
sfms.id";
                $result = $conn->execute_query($query);
                while ($row = $result->fetch_object()) {
                  echo number_format($row->chart_data, 2) . ",";
                }
                ?>
              ]
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
              categories: [
                <?php
                $query = "
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
FROM sfms";
                $result = $conn->execute_query($query);
                while ($row = $result->fetch_object()) {
                  echo "'" . $row->sfm_code . "',";
                }
                ?>
              ]
            }
          };

          var chart = new ApexCharts(document.querySelector("#printRadarChart"), options);
          chart.render();
        </script>
      </div>
      <div class="col-12">
        <hr>
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
            <span class="float-end">Average: <?= number_format($get_avg->chart_data, '2') ?>%</span>
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
(r.`value` / 5) AS total_value,
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
        <hr>
      </div>
      <p class="h5"><strong>SWOT Analysis</strong></p>
      <?php
      $query = "SELECT distinct(`swot_category`) from `swots`";
      $result = $conn->execute_query($query);
      while ($row = $result->fetch_object()) {
        ?>
        <div class="col-6">
          <strong class="text-muted">
            <?= $row->swot_category[0] ?> |
            <?= $row->swot_category ?>
          </strong>
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
        <?php
      }
      ?>
      <hr>
    </div>
  </div>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/footer.php");
?>