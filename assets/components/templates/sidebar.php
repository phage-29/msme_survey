<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-heading">Assessments</li>
    <?php
    // Assuming $conn is your database connection object
    $query = "SELECT * FROM assessment_monitoring WHERE msme_id = ?";
    $result = $conn->execute_query($query, [$msme_id]);
    if ($result && $am_row = $result->fetch_object()) {
      $ref = isset($_GET['ref']) ? $_GET['ref'] : ''; // Avoid undefined index notice
      ?>
      <li class="nav-item">
        <a class="nav-link collapsed <?= $am_row->success_factor ? '' : 'a-disable' ?>"
          href="success-factors.php?ref=<?= $ref ?>">
          <i class="bi bi-check-circle<?= $am_row->success_factor ? '-fill' : '' ?>"></i>
          <span>Success Factor</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed <?= $am_row->swot ? '' : 'a-disable' ?>" href="swot-analysis.php?ref=<?= $ref ?>">
          <i class="bi bi-check-circle<?= $am_row->swot ? '-fill' : '' ?>"></i>
          <span>S.W.O.T.</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed <?= $am_row->competitive_feature ? '' : 'a-disable' ?>"
          href="competitive-features.php?ref=<?= $ref ?>">
          <i class="bi bi-check-circle<?= $am_row->competitive_feature ? '-fill' : '' ?>"></i>
          <span>Competitive Feature</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed <?= $am_row->scorecard ? '' : 'a-disable' ?>"
          href="scorecard.php?ref=<?= $ref ?>">
          <i class="bi bi-bar-chart-line<?= $am_row->scorecard ? '-fill' : '' ?>"></i>
          <span>Generated Scorecard</span>
        </a>
      </li>
    <?php } ?>
  </ul>
</aside><!-- End Sidebar -->

<script>
  $(document).ready(function () {
    var currentLocation = '<?= basename($_SERVER['REQUEST_URI']) ?>'; // Get current URL path
    console.log(currentLocation);
    $('#sidebar-nav a').each(function () {
      if ($(this).attr('href') === currentLocation) {
        $(this).removeClass('collapsed');
      }
    });
  });
</script>