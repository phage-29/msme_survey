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
                                        <img src="assets/img/immis.png" alt=""><img src="assets/img/logo.png"
                                            alt=""><img src="assets/img/wvsu.png" alt="">
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

                                <form class="row g-3 ajax-form">
                                    <div class="col-12">
                                        <label for="province_id" class="form-label">Province</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <select name="province_id" class="form-select" id="province_id"
                                                onchange="document.getElementById('business_name').value=''" required>
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
                                        <p class="small mb-0 text-center"><a href="register.php">Not registered</a></p>
                                        <p class="small mb-0 text-center"><a href="admin.php">Login as admin</a></p>
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