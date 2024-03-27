<?php
$page = "Login";
$protected = false;
require_once("assets/components/includes/common_functions.php");
require_once("assets/components/includes/conn.php");
require_once("assets/components/templates/header.php");
?>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12 d-flex flex-column align-items-center justify-content-center">


                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="d-flex justify-content-center pt-4">
                                    <span class="logo d-flex align-items-center w-auto">
                                        <img src="assets/img/immis.png" alt=""><img src="assets/img/logo.png" alt=""><img src="assets/img/wvsu.png" alt="">
                                    </span>
                                </div><!-- End Logo -->

                                <div class="pt-1 pb-2">
                                    <h6 class="card-title text-center pb-0 fs-6">INTEGRATED MSME MANAGEMENT INFORMATION
                                        SYSTEM
                                        MARKET INTELLIGENCE MODULE
                                    </h6>
                                    <p class="text-center small pt-2">This Market Intelligence (MI) Tool is a combination of
                                        various assessment tools that aim to raise business awareness of MSMEs. After
                                        the assessment, a competitive advantage scorecard will be generated.</p>
                                </div>

                                <form class="row g-3 ajax-form">
                                    <div class="col-lg-4 mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" name="first_name" class="form-control" id="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" name="middle_name" class="form-control" id="middle_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" name="last_name" class="form-control" id="last_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="sex" class="form-label">Sex</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <select name="sex" class="form-select" id="sex" required>
                                                <option selected disabled>--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="age" class="form-label">Age</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                            <select name="age" class="form-select" id="age" required>
                                                <option selected disabled>--</option>
                                                <option value="35 and Below">35 and Below</option>
                                                <option value="36 to 59 years old">36 to 59 years old</option>
                                                <option value="60 above">60 above</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" name="phone" class="form-control" id="phone" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="email" name="email" class="form-control" id="email" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="business_name" class="form-label">Business Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <input type="text" name="business_name" class="form-control" id="business_name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="province_id" class="form-label">Province</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <select name="province_id" class="form-select" id="province_id" required>
                                                <option selected disabled>--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="industry_cluster_id" class="form-label">Industry Cluster</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <select name="industry_cluster_id" class="form-select" id="industry_cluster_id" required>
                                                <option selected disabled>--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="major_business_activity_id" class="form-label">Major Business Activity</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <select name="major_business_activity_id" class="form-select" id="major_business_activity_id" required>
                                                <option selected disabled>--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="edt_level_id" class="form-label">Stage of Business Operation</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <select name="edt_level_id" class="form-select" id="edt_level_id" required>
                                                <option selected disabled>--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <label for="asset_size_id" class="form-label">Asset Size</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                            <select name="asset_size_id" class="form-select" id="asset_size_id" required>
                                                <option selected disabled>--</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div hidden>
                                        <input name="msme_registration" />
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right"></i> Take assessment</button>
                                    </div>
                                    <div class="col-lg-6">
                                        <!-- <p class="small mb-0 text-center"><a href="login.php">Login as admin</a></p> -->
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