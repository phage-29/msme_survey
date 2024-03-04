<?php
$page = "SUCCESS FACTORS";
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
        <form id="sfa-form">
          <input type="hidden" name="ref" id="ref" value="<?= $_GET['ref'] ?>" />
          <?php
          $query = $conn->query("SELECT * FROM sfms");
          while ($row = $query->fetch_object()) {
            ?>
            <div class="accordion mb-3" id="accordion<?= $row->sfm_code ?>">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse<?= $row->sfm_code ?>" aria-expanded="true"
                    aria-controls="collapse<?= $row->sfm_code ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="<?= $row->sfm_desc ?>">
                    <?= $row->sfm ?>
                  </button>
                </h2>
                <div id="collapse<?= $row->sfm_code ?>" class="accordion-collapse collapse show"
                  data-bs-parent="#accordion<?= $row->sfm_code ?>">
                  <div class="accordion-body">
                    <div class="row mt-3">
                      <div class="col-lg-6 col-md-12 col-sm-12 small text-center text-muted d-none d-lg-flex">
                        <p><strong>Criteria</strong></p>
                      </div>
                      <div class="col-lg-6 col-md-12 col-sm-12 small text-muted d-none d-lg-flex row">
                        <div class="col-1"></div>
                        <div class="col-2 small text-center">
                          <strong>Very high</strong>
                        </div>
                        <div class="col-2 small text-center">
                          <strong>High</strong>
                        </div>
                        <div class="col-2 small text-center">
                          <strong>Fair</strong>
                        </div>
                        <div class="col-2 small text-center">
                          <strong>Low</strong>
                        </div>
                        <div class="col-2 small text-center">
                          <strong>Very low</strong>
                        </div>
                        <div class="col-1"></div>
                      </div>
                    </div>
                    <?php
                    $query2 = $conn->query("SELECT * FROM sfsms WHERE sfm_id = $row->id");
                    while ($row2 = $query2->fetch_object()) {
                      ?>
                      <div class="row mt-3">
                        <div class="col-lg-6 col-md-12 col-sm-12 small">
                          <p data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="<?= $row2->sfsm_desc ?>">
                            <?= $row2->sfsm ?>
                          </p>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 row">
                          <div class="col-1"></div>
                          <div class="col-2 small ps-lg-5">
                            <input type="radio" name="<?= $row2->sfsm_code ?>" class="form-check-input"
                              onclick="return sfa(<?= $row->id ?>,<?= $row2->id ?>,<?= $msme_id ?>,5)" style="scale: 1.75;"
                              <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 5")->num_rows ? 'checked' : '' ?> required />
                          </div>
                          <div class="col-2 small ps-lg-5">
                            <input type="radio" name="<?= $row2->sfsm_code ?>" class="form-check-input"
                              onclick="return sfa(<?= $row->id ?>,<?= $row2->id ?>,<?= $msme_id ?>,4)" style="scale: 1.75;"
                              <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 4")->num_rows ? 'checked' : '' ?> />
                          </div>
                          <div class="col-2 small ps-lg-5">
                            <input type="radio" name="<?= $row2->sfsm_code ?>" class="form-check-input"
                              onclick="return sfa(<?= $row->id ?>,<?= $row2->id ?>,<?= $msme_id ?>,3)" style="scale: 1.75;"
                              <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 3")->num_rows ? 'checked' : '' ?> />
                          </div>
                          <div class="col-2 small ps-lg-5">
                            <input type="radio" name="<?= $row2->sfsm_code ?>" class="form-check-input"
                              onclick="return sfa(<?= $row->id ?>,<?= $row2->id ?>,<?= $msme_id ?>,2)" style="scale: 1.75;"
                              <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 2")->num_rows ? 'checked' : '' ?> />
                          </div>
                          <div class="col-2 small ps-lg-5">
                            <input type="radio" name="<?= $row2->sfsm_code ?>" class="form-check-input"
                              onclick="return sfa(<?= $row->id ?>,<?= $row2->id ?>,<?= $msme_id ?>,1)" style="scale: 1.75;"
                              <?= $conn->query("SELECT * FROM responses WHERE sfm_id=$row->id and sfsm_id=$row2->id and msme_id=$msme_id and value = 1")->num_rows ? 'checked' : '' ?> />
                          </div>
                          <div class="col-1"></div>
                        </div>
                      </div>
                      <hr>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </div>

            </div>
            <?php
          }
          ?>
          <div class="mb-3 text-end">
            <a href="validation.php" class="btn btn-primary">Prev</a>
            <button class="btn btn-primary">Next</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <script>
    function sfa(sfm_id, sfsm_id, msme_id, value) {
      $.ajax({
        url: "assets/components/includes/process.php",
        method: "POST",
        data: {
          sfm_id: sfm_id,
          sfsm_id: sfsm_id,
          msme_id: msme_id,
          value: value,
          sfa: '',
        },
        dataType: "json",
        success: function (response) {
          console.log("message");
        },
      });
    }
  </script>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/modals.php");
require_once("assets/components/templates/footer.php");
?>