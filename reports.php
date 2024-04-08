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

  <?php
  if (isset($_GET['msme_id'])) {
    $msme_id = $_GET['msme_id'];
  ?>
    <div class="card">
      <div class="card-header">Success Factor Main Assessment</div>
      <div class="card-body">
        <table id="sfm_assessment" class="w-100">
          <thead>
            <tr>
              <th>Code</th>
              <th>Success Factor</th>
              <th>Description</th>
              <th>Total Average</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $conn->query("SELECT
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
                    AND msme_id = $msme_id
            ) mr2 ON s2.id = mr2.sfm_id
        GROUP BY
            s2.id");
            while ($row = $query->fetch_object()) {
            ?>
              <tr>
                <td><?= $row->sfm_code ?></td>
                <td><?= $row->sfm ?></td>
                <td><?= $row->sfm_desc ?></td>
                <td><?= number_format($row->highest_average * 100, 2) ?>%</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $('#sfm_assessment').DataTable({
          scrollX: true,
          paging: false
        });
      })
    </script>

    <div class="card">
      <div class="card-header">Success Factor Sub Main Assessment</div>
      <div class="card-body">
        <table id="sfsm_assessment" class="w-100">
          <thead>
            <tr>
              <th>Success Factor Main</th>
              <th>Success Factor Sub Main</th>
              <th>Very High</th>
              <th>High</th>
              <th>Average</th>
              <th>Low</th>
              <th>Very Low</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = $conn->query("select
            r.msme_id,
            r.sfm_id,
            s.sfm,
            ss.sfsm,
            lt.selection,
            lt.very_high,
            lt.high,
            lt.average,
            lt.low,
            lt.very_low
        from
            responses r
            LEFT JOIN sfms s ON r.`sfm_id` = s.id
            LEFT JOIN sfsms ss ON r.`sfsm_id` = ss.id
            LEFT JOIN lookup_table lt ON r.`value` = lt.id
        WHERE
            assessment_type_id = 1
            AND msme_id = $msme_id");
            while ($row = $query->fetch_object()) {
            ?>
              <tr>
                <td><?= $row->sfm ?></td>
                <td><?= $row->sfsm ?></td>
                <td><?= $row->very_high ?></td>
                <td><?= $row->high ?></td>
                <td><?= $row->average ?></td>
                <td><?= $row->low ?></td>
                <td><?= $row->very_low ?></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $('#sfsm_assessment').DataTable({
          scrollX: true,
          paging: false
        });
      })
    </script>
  <?php
  } else {
  ?>
    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-title"></div>
            <div class="card-body">
              <table id="actual_data" class="small">
                <thead>
                  <tr>
                    <th class="text-nowrap">msme</th>
                    <th class="text-nowrap">province</th>
                    <th class="text-nowrap">asset size</th>
                    <th class="text-nowrap">edt level</th>
                    <th class="text-nowrap">industry cluster</th>
                    <th class="text-nowrap">major business activity</th>
                    <?php
                    $query = $conn->query("SELECT * FROM sfms");
                    while ($row = $query->fetch_object()) {
                    ?>
                      <th class="text-nowrap"><?= $row->sfm_code ?> Score</th>
                    <?php
                    }
                    ?>
                    <th class="text-nowrap">Total Average</th>
                    <th class="text-nowrap">%</th>
                  </tr>
                </thead>
                <tbody id="tbody_data">
                </tbody>
              </table>
            </div>
          </div>

        </div><!-- End Left side columns -->

      </div>
    </section>
    <script>
      $(document).ready(function() {
        Swal.fire({
          title: "Loading",
          html: "Please wait...",
          allowOutsideClick: false,
          didOpen: function() {
            Swal.showLoading();
          },
        });
        $.ajax({
          url: 'fetch_data.php',
          method: 'GET',
          dataType: 'html',
          success: function(response) {
            Swal.close();
            $('#tbody_data').html(response);
            $('#actual_data').DataTable({
              fixedColumns: {
                start: 1,
                end: 1
              },
              scrollX: true
            });
          },
          error: function(xhr, status, error) {
            console.error('Error fetching data:', status, error);
          }
        });
      });
    </script>
  <?php
  }
  ?>

</main><!-- End #main -->
<?php
require_once("assets/components/templates/modals.php");
require_once("assets/components/templates/footer.php");
?>