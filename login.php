<?php
$page = "Assessment";
$protected = false;
require_once ("assets/components/includes/common_functions.php");
require_once ("assets/components/includes/conn.php");
require_once ("assets/components/templates/header.php");
?>
<main>
  <div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 col-md-8 d-flex flex-column align-items-center justify-content-center">


            <div class="card mb-3">

              <div class="card-body">

                <div class="d-flex justify-content-center pt-4">
                  <span class="logo d-flex align-items-center w-auto">
                    <img src="assets/img/immis.png" alt=""><img src="assets/img/logo.png" alt=""><img
                      src="assets/img/wvsu.png" alt="">
                  </span>
                </div><!-- End Logo -->

                <div class="pt-1 pb-2">
                  <h6 class="card-title text-center pb-0 fs-6">INTEGRATED MSME MANAGEMENT INFORMATION
                    SYSTEM MARKET INTELLIGENCE
                  </h6>
                  <p class="text-center small pt-2">This Market Intelligence (MI) Tool is a
                    combination of
                    various assessment tools that aim to raise business awareness of MSMEs. After
                    the assessment, a competitive advantage scorecard will be generated.</p>
                </div>

                <form class="row g-3 needs-validation" data-toggle="validator" novalidate>

                  <div class="col-12">
                    <label for="yourUsername" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="text" name="username" class="form-control" id="yourUsername" required>
                      <div class="invalid-feedback">Please enter your username.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input class="" type="checkbox" name="remember" value="true" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                  </div>
                  <div class="col-12">
                    <p class="small mb-0">Don't have account? <a href="register.php">Create an account</a></p>
                  </div>
                </form>
              </div>
            </div>

            <div class="credits">
              Designed by <a href="#phage">Phage</a>
            </div>

          </div>
        </div>
      </div>

    </section>

  </div>
</main><!-- End #main -->
<?php
require_once ("assets/components/templates/footer.php");
?>