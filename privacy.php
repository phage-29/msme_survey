<?php
$page = "Blank Page";
$protected = false;
require_once("assets/components/templates/header.php");
require_once("assets/components/templates/topbar.php");
require_once("assets/components/templates/sidebar.php");
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>
      <?= $page ?>
    </h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Success Factors</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem aspernatur quasi quam, labore optio
              veritatis provident explicabo harum dignissimos. Sunt dolore itaque perferendis voluptate fugit ipsum
              totam quis laudantium dolorum.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->
<?php
require_once("assets/components/templates/modals.php");
require_once("assets/components/templates/footer.php");
?>