<?php
$page = "Register";
$protected = false;
require_once("assets/components/templates/header.php");
?>
<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-12 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="dashboard.php" class="logo d-flex align-items-center w-auto">
                <img src="assets/img/logo.png" alt="">
                <span class="d-none d-lg-block">NiceAdmin</span>
              </a>
            </div><!-- End Logo -->

            <div class="card mb-3">

              <div class="card-body">

                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">MSME COMPETITIVE ADVANTAGE SCORECARD</h5>
                  <!-- <p class="text-center small">Enter your personal details to create account</p> -->
                </div>
                <div class="row">
                  <p>Code: R6-ILO-CityProper-001</p>
                  <p>Business Name: HaBambooHay</p>
                  <div id="qrcode"></div>
                  <script type="text/javascript">
                    var qrcode = new QRCode(document.getElementById("qrcode"), {
                      text: "http://jindo.dev.naver.com/collie",
                      width: 128,
                      height: 128,
                      colorDark: "#000000",
                      colorLight: "#ffffff",
                      correctLevel: QRCode.CorrectLevel.H
                    });
                  </script>
                  <span>Industry Cluster:</span>
                  <span>EDT Level:</span>
                  <span>Asset Size:</span>
                </div>

              </div>
            </div>

            <div class="credits">
              <!-- All the links in the footer should remain intact. -->
              <!-- You can delete the links only if you purchased the pro version. -->
              <!-- Licensing information: https://bootstrapmade.com/license/ -->
              <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
              Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->
<?php
require_once("assets/components/templates/footer.php");
?>