<?php
$page = "Login";
$protected = false;
require_once("assets/components/templates/header.php");
?>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a href="dashboard.php" class="logo d-flex align-items-center w-auto">
                                <img src="assets/img/logo.png" alt="">
                                <span class="d-none d-lg-block">
                                    <?= website ?>
                                </span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">MSME Assessment</h5>
                                    <p class="text-center small">Fill out the fields to start the assessment.</p>
                                </div>

                                <form class="row g-3 ajax-form">
                                    <div class="col-12">
                                        <label for="province_id" class="form-label">Province</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <select name="province_id" class="form-select" id="province_id" required>
                                                <option selected disabled>--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="business_name" class="form-label">Business Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" name="business_name" class="form-control"
                                                id="business_name" required>
                                        </div>
                                    </div>

                                    <div hidden>
                                        <input name="msme_validation" />
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit"><i
                                                class="bi bi-box-arrow-in-right"></i> Take assessment</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="small mb-0 text-center"><a href="login.php">Login as admin</a></p>
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
require_once("assets/components/templates/footer.php");
?>