<?php
$page = "COMPETITIVE FEATURES";
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
    <p>
      <em>
        <strong>Directions:</strong>Kindly answer Yes or No on all the items. YES means you utilize the kind of feature
        and NO if otherwise.
      </em>
    </p>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <form id="scf-form">
          <input type="hidden" name="ref" id="ref" value="<?= $_GET['ref'] ?>" />
          <?php
          $query = $conn->query("SELECT * FROM cfms");
          while ($row = $query->fetch_object()) {
          ?>
            <div class="accordion mb-3" id="accordion<?= $row->cfm_code ?>">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $row->cfm_code ?>" aria-expanded="true" aria-controls="collapse<?= $row->cfm_code ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="<?= $row->cfm_desc ?>">
                    <?= $row->cfm ?>
                  </button>
                </h2>
                <div id="collapse<?= $row->cfm_code ?>" class="accordion-collapse collapse show" data-bs-parent="#accordion<?= $row->cfm_code ?>">
                  <div class="accordion-body">
                    <table class="table">
                      <tbody>
                        <?php
                        $query2 = $conn->query("SELECT * FROM cfsms c WHERE c.cfm_id = $row->id");
                        while ($row2 = $query2->fetch_object()) {
                          $query3 = $conn->query("SELECT * FROM responses WHERE cfm_id=$row->id and cfsm_id=$row2->id and msme_id=$msme_id");
                          $get_query3 = $query3->fetch_object();
                        ?>
                          <tr>
                            <td scope="row">
                              <?= $row2->cfsm ?>
                              <div class="float-end">
                                <div class="form-check form-check-inline mb-3">
                                  <input class="form-check-input mt-3" onclick="return cfa(<?= $row->id ?>,<?= $row2->id ?>,<?= $msme_id ?>,1)" type="radio" style="scale: 1.78;" name="options<?= $row2->id ?>" id="yesradio<?= $row2->id ?>" <?= isset($get_query3->value) ? ($get_query3->value == 1 ? 'checked' : '') : '' ?> required />
                                  <label class="form-check-label mt-3" for="yesradio<?= $row2->id ?>">Yes</label>
                                </div>
                                <div class="form-check form-check-inline mb-3">
                                  <input class="form-check-input mt-3" onclick="return cfa(<?= $row->id ?>,<?= $row2->id ?>,<?= $msme_id ?>,2)" type="radio" style="scale: 1.78;" name="options<?= $row2->id ?>" id="noradio<?= $row2->id ?>" <?= isset($get_query3->value) ? ($get_query3->value == 1 ? '' : 'checked') : '' ?> />
                                  <label class="form-check-label mt-3" for="noradio<?= $row2->id ?>">No</label>
                                </div>
                              </div>
                            </td>
                            <td id="colorIndicator<?= $row2->id ?>" class="<?= isset($get_query3->value) ? ($get_query3->value == 1 ? 'bg-success' : 'bg-danger') : 'bg-secondary-light' ?>" width="5%"></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>

                  </div>
                </div>
              </div>

            </div>
          <?php
          }
          ?>
          <div class="mb-3 text-end">
            <a href="swot-analysis.php?ref=<?= $_GET['ref'] ?>" class="btn btn-primary">Prev</a>
            <button class="btn btn-primary" <?= empty($am_row->comments_suggestions) ? 'type="button" data-bs-toggle="modal" data-bs-target="#suggestionsModal"' : ' type="submit"' ?>>Next</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <script>
    function cfa(cfm_id, cfsm_id, msme_id, value) {
      $.ajax({
        url: "assets/components/includes/process.php",
        method: "POST",
        data: {
          cfm_id: cfm_id,
          cfsm_id: cfsm_id,
          msme_id: msme_id,
          value: value,
          cfa: '',
        },
        dataType: "json",
        success: function(response) {
          console.log("message");
          if (value == 1) {
            $('#colorIndicator' + cfsm_id).addClass('bg-success').removeClass('bg-danger').removeClass('bg-secondary-light');
          } else {
            $('#colorIndicator' + cfsm_id).addClass('bg-danger').removeClass('bg-success').removeClass('bg-secondary-light');
          }
        },
      });
    }
  </script>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/modals.php");
require_once("assets/components/templates/footer.php");
?>