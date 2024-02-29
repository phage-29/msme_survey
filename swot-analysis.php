<?php
$page = "SWOT ANALYSIS";
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
        <form id="saa-form">
          <input type="hidden" name="ref" id="ref" value="<?= $_GET['ref'] ?>" />
          <?php
          $query = $conn->query("SELECT DISTINCT(swot_category) FROM swots");
          while ($row = $query->fetch_object()) {
            ?>
            <div class="accordion mb-3" id="accordion<?= $row->swot_category ?>">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse<?= $row->swot_category ?>" aria-expanded="true"
                    aria-controls="collapse<?= $row->swot_category ?>">
                    <?= $row->swot_category ?>
                  </button>
                </h2>
                <div id="collapse<?= $row->swot_category ?>" class="accordion-collapse collapse show"
                  data-bs-parent="#accordion<?= $row->swot_category ?>">
                  <div class="accordion-body">
                    <div class="row mt-3">
                      <div class="col-lg-6 col-md-12 col-sm-12 small text-muted">
                        <p><strong>Selection</strong></p>
                      </div>
                      <div class="col-lg-6 col-md-12 col-sm-12 small text-muted">
                        <p><strong>Selected</strong></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6 col-md-12 col-sm-12 small text-muted">
                        <ul id="<?= $row->swot_category ?>Selection" class="list-group border border-2"
                          style="height: 300px; max-height: 300px; overflow-y:auto">
                          <?php
                          $query2 = $conn->query("SELECT * FROM swots WHERE swot_category = '$row->swot_category' AND id NOT IN (SELECT swot_id FROM responses WHERE msme_id = $msme_id AND swot_id IS NOT NULL)");
                          while ($row2 = $query2->fetch_object()) {
                            ?>
                            <li class="list-group-item">
                              <p class="form-check-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip" data-bs-title="<?= $row2->swot_desc ?>">
                                <?= $row2->swot ?>
                                <button data-swot-id="<?= $row2->id ?>" type="button"
                                  class="float-end btn btn-primary btn-sm add-<?= $row->swot_category ?>"><i
                                    class="bi bi-plus-lg"></i></button>
                              </p>
                            </li>
                            <?php
                          }
                          ?>
                        </ul>
                      </div>
                      <div class="col-lg-6 col-md-12 col-sm-12 small text-muted">
                        <ul id="<?= $row->swot_category ?>Selected" class="list-group border border-2"
                          style="height: 300px; max-height: 300px; overflow-y:auto">
                          <?php
                          $query2 = $conn->query("SELECT * FROM responses r LEFT JOIN swots s ON r.swot_id = s.id WHERE r.swot_id IS NOT NULL AND r.msme_id = $msme_id AND s.swot_category = '$row->swot_category'");
                          while ($row2 = $query2->fetch_object()) {
                            ?>
                            <li class="list-group-item">
                              <p class="form-check-label" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-custom-class="custom-tooltip" data-bs-title="<?= $row2->swot_desc ?>">
                                <?= $row2->swot ?>
                                <button data-swot-id="<?= $row2->swot_id ?>" type="button"
                                  class="float-end btn btn-danger btn-sm remove-<?= $row->swot_category ?>"><i
                                    class="bi bi-x-lg"></i></button>
                              </p>
                            </li>
                            <?php
                          }
                          ?>
                        </ul>
                      </div>
                    </div>

                    <!-- Bootstrap Bundle with Popper -->
                    <script>
                      $(document).ready(function () {
                        // Add button click event
                        $(document).on('click', '.add-<?= htmlspecialchars($row->swot_category) ?>', function () {
                          var listItem = $(this).closest('.list-group-item');
                          listItem.detach();
                          $(this).addClass('remove-<?= htmlspecialchars($row->swot_category) ?>').removeClass('add-<?= htmlspecialchars($row->swot_category) ?>');
                          $(this).addClass('btn-danger').removeClass('btn-primary');
                          $(this).html('<i class="bi bi-x-lg"></i>');
                          $('#<?= htmlspecialchars($row->swot_category) ?>Selected').append(listItem);

                          $.ajax({
                            url: "assets/components/includes/process.php",
                            method: "POST",
                            data: {
                              swot_id: $(this).data('swot-id'),
                              msme_id: <?= $msme_id ?>,
                              action: 'add',
                              saa: '',
                            },
                            dataType: "json",
                            success: function (response) {
                              console.log("message");
                            },
                          });
                        });

                        // Remove button click event
                        $(document).on('click', '.remove-<?= htmlspecialchars($row->swot_category) ?>', function () {
                          var listItem = $(this).closest('.list-group-item');
                          listItem.detach();
                          $(this).addClass('add-<?= htmlspecialchars($row->swot_category) ?>').removeClass('remove-<?= htmlspecialchars($row->swot_category) ?>');
                          $(this).addClass('btn-primary').removeClass('btn-danger');
                          $(this).html('<i class="bi bi-plus-lg"></i>');
                          $('#<?= htmlspecialchars($row->swot_category) ?>Selection').append(listItem);

                          $.ajax({
                            url: "assets/components/includes/process.php",
                            method: "POST",
                            data: {
                              swot_id: $(this).data('swot-id'),
                              msme_id: <?= $msme_id ?>,
                              action: 'remove',
                              saa: '',
                            },
                            dataType: "json",
                            success: function (response) {
                              console.log("message");
                            },
                          });
                        });
                      });
                    </script>

                  </div>
                </div>

              </div>
            </div>
            <?php
          }
          ?>
          <div class="mb-3 text-end">
            <a href="success-factors.php?ref=<?= $_GET['ref'] ?>" class="btn btn-primary">Prev</a>
            <button class="btn btn-primary">Next</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/modals.php");
require_once("assets/components/templates/footer.php");
?>