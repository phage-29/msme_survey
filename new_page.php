<?php
$page = "Blank Page";
$protected = true;
require_once("assets/templates/header.php");
require_once("assets/templates/topbar.php");
require_once("assets/templates/sidebar.php");
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1><?= $page ?></h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
        <li class="breadcrumb-item">Pages</li>
        <li class="breadcrumb-item active"><?= $page ?></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-6">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Example Card</h5>
            <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
          </div>
        </div>

      </div>

      <div class="col-lg-6">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Example Card</h5>
            <p>This is an examle page with no contrnt. You can use it as a starter for your custom pages.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php
require_once("assets/templates/modals.php");
require_once("assets/templates/footer.php");
?>