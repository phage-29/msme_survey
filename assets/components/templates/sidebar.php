<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">Assessments</li>

    <?php
    echo decryptID($_GET["ref"], secret_key);
    $query = "SELECT * FROM assessment_monitoring WHERE msme_id = ?";
    $result = $conn->execute_query($query, [$msme_id]);
    while ($row = $result->fetch_object()) {
      ?>
      <li class="nav-item">
        <a class="nav-link collapsed <?= $row->success_factor ? '' : 'a-disable' ?>" href="profile.php">
          <i class="bi bi-check-circle<?= $row->success_factor ? '-fill' : '' ?>"></i>
          <span>Success Factor</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed <?= $row->swot ? '' : 'a-disable' ?>" href="profile.php">
          <i class="bi bi-check-circle<?= $row->swot ? '-fill' : '' ?>"></i>
          <span>S.W.O.T.</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed <?= $row->competitive_feature ? '' : 'a-disable' ?>" href="profile.php">
          <i class="bi bi-check-circle<?= $row->competitive_feature ? '-fill' : '' ?>"></i>
          <span>Competitive Feature</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed <?= $row->scorecard ? '' : 'a-disable' ?>" href="profile.php">
          <i class="bi bi-bar-chart-line<?= $row->scorecard ? '-fill' : '' ?>"></i>
          <span>Generated Scorecard</span>
        </a>
      </li>
      <?php
    }
    ?>
  </ul>

</aside><!-- End Sidebar-->