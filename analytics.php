<?php
$page = "Reports";
$protected = true;
require_once("assets/components/templates/header.php");
require_once("assets/components/templates/topbar.php");
require_once("assets/components/templates/sidebar.php");
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= $page ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
        <?php
        if (isset($_GET['msme_id'])) {
        ?>
          <li class="breadcrumb-item"><a href="reports.php"><?= $page ?></a></li>
          <li class="breadcrumb-item active"><?= $_GET['msme_id'] ?></li>
        <?php
        } else {
        ?>
          <li class="breadcrumb-item active"><?= $page ?></li>
        <?php
        }
        ?>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">


              <div class="card-body">
                <h5 class="card-title">Respondents</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $conn->query("SELECT * FROM assessment_monitoring")->num_rows ?></h6>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">


              <div class="card-body">
                <h5 class="card-title">Complete Response</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $conn->query("SELECT * FROM assessment_monitoring WHERE scorecard = 1")->num_rows ?></h6>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">


              <div class="card-body">
                <h5 class="card-title">In-complete Response</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $conn->query("SELECT * FROM assessment_monitoring WHERE scorecard IS NULL")->num_rows ?></h6>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Customers Card -->

          <div class="pagetitle">
            <h1>Dashboard</h1>
          </div><!-- End Page Title -->
          <!-- Reports -->
          <div class="col-lg-6">
            <div class="card">


              <div class="card-body">
                <h5 class="card-title">MSME Per Province</h5>

                <!-- Line Chart -->
                <div id="perProvince"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    var options = {
                      series: [{
                        data: [
                          <?php
                          $query = $conn->query("SELECT COUNT(p.province) AS data_value FROM msmes m LEFT JOIN provinces p ON m.province_id = p.id WHERE p.province IS NOT NULL GROUP BY p.province");
                          while ($row = $query->fetch_object()) {
                            echo $row->data_value . ',';
                          }
                          ?>
                        ]
                      }],
                      chart: {
                        events: {
                          events: {
                            markerClick: function(event, chartContext, {
                              seriesIndex,
                              dataPointIndex,
                              config
                            }) {
                              console.log(event)
                            }
                          }
                        },
                        toolbar: {
                          show: true,
                          offsetX: 0,
                          offsetY: 0,
                          tools: {
                            download: true,
                            selection: true,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true | '<img src="/static/icons/reset.png" width="20">',
                            customIcons: []
                          },
                          export: {
                            csv: {
                              filename: undefined,
                              columnDelimiter: ',',
                              headerCategory: 'category',
                              headerValue: 'value',
                              dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                              }
                            },
                            svg: {
                              filename: undefined,
                            },
                            png: {
                              filename: undefined,
                            }
                          },
                          autoSelected: 'zoom'
                        },
                        type: 'bar',
                        height: 350
                      },
                      plotOptions: {
                        bar: {
                          borderRadius: 4,
                          horizontal: true,
                        }
                      },
                      dataLabels: {
                        enabled: false
                      },
                      xaxis: {
                        categories: [
                          <?php
                          $query = $conn->query("SELECT p.province FROM msmes m LEFT JOIN provinces p ON m.province_id = p.id WHERE p.province IS NOT NULL GROUP BY p.province");
                          while ($row = $query->fetch_object()) {
                            echo '"' . $row->province . '",';
                          }
                          ?>
                        ],
                      }
                    };

                    var chart = new ApexCharts(document.querySelector("#perProvince"), options);
                    chart.render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->

          <!-- Reports -->
          <div class="col-lg-6">
            <div class="card">


              <div class="card-body">
                <h5 class="card-title">MSME Per Industry Cluster</h5>

                <!-- Line Chart -->
                <div id="perIndustryCluster"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    var options = {
                      series: [
                        <?php
                        $query = $conn->query("SELECT COUNT(p.industry_cluster) AS data_value FROM msmes m LEFT JOIN industry_clusters p ON m.industry_cluster_id = p.id WHERE p.industry_cluster IS NOT NULL GROUP BY p.industry_cluster");
                        while ($row = $query->fetch_object()) {
                          echo $row->data_value . ',';
                        }
                        ?>
                      ],
                      chart: {
                        events: {
                          events: {
                            markerClick: function(event, chartContext, {
                              seriesIndex,
                              dataPointIndex,
                              config
                            }) {
                              console.log(event)
                            }
                          }
                        },
                        toolbar: {
                          show: true,
                          offsetX: 0,
                          offsetY: 0,
                          tools: {
                            download: true,
                            selection: true,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true | '<img src="/static/icons/reset.png" width="20">',
                            customIcons: []
                          },
                          export: {
                            csv: {
                              filename: undefined,
                              columnDelimiter: ',',
                              headerCategory: 'category',
                              headerValue: 'value',
                              dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                              }
                            },
                            svg: {
                              filename: undefined,
                            },
                            png: {
                              filename: undefined,
                            }
                          },
                          autoSelected: 'zoom'
                        },
                        type: 'pie',
                        height: 350
                      },
                      labels: [
                        <?php
                        $query = $conn->query("SELECT p.industry_cluster FROM msmes m LEFT JOIN industry_clusters p ON m.industry_cluster_id = p.id WHERE p.industry_cluster IS NOT NULL GROUP BY p.industry_cluster");
                        while ($row = $query->fetch_object()) {
                          echo '"' . $row->industry_cluster . '",';
                        }
                        ?>
                      ],
                      responsive: [{
                        breakpoint: 480,
                        options: {
                          chart: {
                            events: {
                              events: {
                                markerClick: function(event, chartContext, {
                                  seriesIndex,
                                  dataPointIndex,
                                  config
                                }) {
                                  console.log(event)
                                }
                              }
                            },
                            width: 200
                          },
                          legend: {
                            position: 'bottom'
                          }
                        }
                      }]
                    };

                    var chart = new ApexCharts(document.querySelector("#perIndustryCluster"), options);
                    chart.render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->

          <!-- Reports -->
          <div class="col-lg-4">
            <div class="card">


              <div class="card-body">
                <h5 class="card-title">MSME Per Major Business Activity</h5>

                <!-- Line Chart -->
                <div id="perMajorBusinessActivity"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    var options = {
                      series: [
                        <?php
                        $query = $conn->query("SELECT COUNT(p.major_business_activity) AS data_value FROM msmes m LEFT JOIN major_business_activities p ON m.major_business_activity_id = p.id WHERE p.major_business_activity IS NOT NULL GROUP BY p.major_business_activity");
                        while ($row = $query->fetch_object()) {
                          echo $row->data_value . ',';
                        }
                        ?>
                      ],
                      chart: {
                        events: {
                          events: {
                            markerClick: function(event, chartContext, {
                              seriesIndex,
                              dataPointIndex,
                              config
                            }) {
                              console.log(event)
                            }
                          }
                        },
                        toolbar: {
                          show: true,
                          offsetX: 0,
                          offsetY: 0,
                          tools: {
                            download: true,
                            selection: true,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true | '<img src="/static/icons/reset.png" width="20">',
                            customIcons: []
                          },
                          export: {
                            csv: {
                              filename: undefined,
                              columnDelimiter: ',',
                              headerCategory: 'category',
                              headerValue: 'value',
                              dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                              }
                            },
                            svg: {
                              filename: undefined,
                            },
                            png: {
                              filename: undefined,
                            }
                          },
                          autoSelected: 'zoom'
                        },
                        type: 'polarArea',
                        height: 350
                      },
                      stroke: {
                        colors: ['#fff']
                      },
                      fill: {
                        opacity: 0.8
                      },
                      labels: [
                        <?php
                        $query = $conn->query("SELECT p.major_business_activity FROM msmes m LEFT JOIN major_business_activities p ON m.major_business_activity_id = p.id WHERE p.major_business_activity IS NOT NULL GROUP BY p.major_business_activity");
                        while ($row = $query->fetch_object()) {
                          echo '"' . $row->major_business_activity . '",';
                        }
                        ?>
                      ],
                      responsive: [{
                        breakpoint: 480,
                        options: {
                          chart: {
                            events: {
                              events: {
                                markerClick: function(event, chartContext, {
                                  seriesIndex,
                                  dataPointIndex,
                                  config
                                }) {
                                  console.log(event)
                                }
                              }
                            },
                            width: 200
                          },
                          legend: {
                            position: 'bottom'
                          }
                        }
                      }]
                    };

                    var chart = new ApexCharts(document.querySelector("#perMajorBusinessActivity"), options);
                    chart.render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->

          <!-- Reports -->
          <div class="col-lg-4">
            <div class="card">


              <div class="card-body">
                <h5 class="card-title">MSME Per Asset Size</h5>

                <!-- Line Chart -->
                <div id="perAssetSize"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    var options = {
                      series: [
                        <?php
                        $query = $conn->query("SELECT COUNT(p.asset_size) AS data_value FROM msmes m LEFT JOIN asset_sizes p ON m.asset_size_id = p.id WHERE p.asset_size IS NOT NULL GROUP BY p.asset_size");
                        while ($row = $query->fetch_object()) {
                          echo $row->data_value . ',';
                        }
                        ?>
                      ],
                      chart: {
                        events: {
                          events: {
                            markerClick: function(event, chartContext, {
                              seriesIndex,
                              dataPointIndex,
                              config
                            }) {
                              console.log(event)
                            }
                          }
                        },
                        toolbar: {
                          show: true,
                          offsetX: 0,
                          offsetY: 0,
                          tools: {
                            download: true,
                            selection: true,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: true,
                            reset: true | '<img src="/static/icons/reset.png" width="20">',
                            customIcons: []
                          },
                          export: {
                            csv: {
                              filename: undefined,
                              columnDelimiter: ',',
                              headerCategory: 'category',
                              headerValue: 'value',
                              dateFormatter(timestamp) {
                                return new Date(timestamp).toDateString()
                              }
                            },
                            svg: {
                              filename: undefined,
                            },
                            png: {
                              filename: undefined,
                            }
                          },
                          autoSelected: 'zoom'
                        },
                        type: 'donut',
                        height: 350
                      },
                      labels: [
                        <?php
                        $query = $conn->query("SELECT p.asset_size FROM msmes m LEFT JOIN asset_sizes p ON m.asset_size_id = p.id WHERE p.asset_size IS NOT NULL GROUP BY p.asset_size");
                        while ($row = $query->fetch_object()) {
                          echo '"' . $row->asset_size . '",';
                        }
                        ?>
                      ],
                      responsive: [{
                        breakpoint: 480,
                        options: {
                          chart: {
                            events: {
                              events: {
                                markerClick: function(event, chartContext, {
                                  seriesIndex,
                                  dataPointIndex,
                                  config
                                }) {
                                  console.log(event)
                                }
                              }
                            },
                            width: 200
                          },
                          legend: {
                            position: 'bottom'
                          }
                        }
                      }]
                    };

                    var chart = new ApexCharts(document.querySelector("#perAssetSize"), options);
                    chart.render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->

          <!-- Reports -->
          <div class="col-lg-4">
            <div class="card">


              <div class="card-body">
                <h5 class="card-title">MSME Per EDT Level</h5>

                <!-- Line Chart -->
                <div id="perEDTLevel"></div>

                <script>
                  document.addEventListener("DOMContentLoaded", () => {
                    var options = {
                      series: [{
                        data: [
                          <?php
                          $query = $conn->query("SELECT el.edt_level_code, count(el.edt_level) AS data_value FROM msmes m LEFT JOIN edt_levels el ON m.edt_level_id = el.id WHERE el.edt_level IS NOT NULL GROUP BY el.edt_level");
                          while ($row = $query->fetch_object()) {
                          ?> {
                              x: '<?= $row->edt_level_code ?>',
                              y: <?= $row->data_value ?>
                            },
                          <?php
                          }
                          ?>
                        ]
                      }],
                      legend: {
                        show: false
                      },
                      chart: {
                        events: {
                          events: {
                            markerClick: function(event, chartContext, {
                              seriesIndex,
                              dataPointIndex,
                              config
                            }) {
                              console.log(event)
                            }
                          }
                        },
                        height: 350,
                        type: 'treemap'
                      },
                      title: {
                        text: undefined
                      }
                    };

                    var chart = new ApexCharts(document.querySelector("#perEDTLevel"), options);
                    chart.render();
                  });
                </script>
                <!-- End Line Chart -->

              </div>

            </div>
          </div><!-- End Reports -->



        </div>
      </div><!-- End Left side columns -->

    </div>
  </section>

</main><!-- End #main -->
<?php
require_once("assets/components/templates/modals.php");
require_once("assets/components/templates/footer.php");
?>