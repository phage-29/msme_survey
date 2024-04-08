<modals>

    <script>
        $(document).ready(function() {
            <?php
            if (isset($am_row->privacy) && $am_row->privacy != 1) {
            ?>
                $('#privacyModal').modal('show');
            <?php
            }
            ?>
        });
    </script>

    <div class="modal fade" id="suggestionsModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="suggestionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="suggestionsModalLabel">Comments and Suggestions</h1>
                </div>
                <div class="modal-body">
                    <form id="comments-form">
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="comments_suggestions" name="comments_suggestions" style="height: 150px" required></textarea>
                                <label for="comments_suggestions">Comments/suggestions regarding this system.</label>
                            </div>
                        </div>
                        <div hidden>
                            <input value="<?= $msme_id ?>" name="msme_id" />
                        </div>
                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if (isset($_GET['ref'])) {
        if (
            !isset($get_msme->first_name) ||
            !isset($get_msme->middle_name) ||
            !isset($get_msme->last_name) ||
            !isset($get_msme->phone) ||
            !isset($get_msme->sex) ||
            !isset($get_msme->email) ||
            !isset($get_msme->business_name) ||
            !isset($get_msme->industry_cluster_id) ||
            !isset($get_msme->major_business_activity_id) ||
            !isset($get_msme->edt_level_id) ||
            !isset($get_msme->asset_size_id) ||
            empty($get_msme->first_name) ||
            empty($get_msme->middle_name) ||
            empty($get_msme->last_name) ||
            empty($get_msme->phone) ||
            empty($get_msme->sex) ||
            empty($get_msme->email) ||
            empty($get_msme->business_name) ||
            empty($get_msme->industry_cluster_id) ||
            empty($get_msme->major_business_activity_id) ||
            empty($get_msme->edt_level_id) ||
            empty($get_msme->asset_size_id)
        ) {
    ?>
            <div class="modal fade" data-bs-backdrop="static" id="updateProfile" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Update Profile</h1>
                        </div>
                        <div class="modal-body">
                            <form class="g-3 ajax-form">
                                <?php
                                if (!isset($get_msme->first_name) || empty($get_msme->first_name)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" id="first_name" required>
                                    </div>
                                <?php
                                }
                                if (!isset($get_msme->middle_name) || empty($get_msme->middle_name)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" class="form-control" id="middle_name" required>
                                    </div>
                                <?php
                                }
                                if (!isset($get_msme->last_name) || empty($get_msme->last_name)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" id="last_name" required>
                                    </div>
                                <?php
                                }
                                if (!isset($get_msme->phone) || empty($get_msme->phone)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" id="phone" required>
                                    </div>
                                <?php
                                }
                                if (!isset($get_msme->sex) || empty($get_msme->sex)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="sex" class="form-label">Sex</label>
                                        <select name="sex" class="form-select">
                                            <option selected disabled>--select--</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                <?php
                                }
                                if (!isset($get_msme->email) || empty($get_msme->email)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                    </div>
                                <?php
                                }
                                if (!isset($get_msme->business_name) || empty($get_msme->business_name)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="business_name" class="form-label">Business Name</label>
                                        <input type="text" name="business_name" class="form-control" id="business_name" required>
                                    </div>
                                <?php
                                }
                                ?>
                                <?php if (!isset($get_msme->province_id) || empty($get_msme->province_id)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="province_id" class="form-label">Province</label>
                                        <select name="province_id" class="form-select" id="province_id" required>
                                            <option selected disabled>--</option>
                                        </select>
                                    </div>

                                <?php
                                }
                                if (!isset($get_msme->industry_cluster_id) || empty($get_msme->industry_cluster_id)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="industry_cluster_id" class="form-label">Industry Cluster</label>
                                        <select name="industry_cluster_id" class="form-select" id="industry_cluster_id" required>
                                            <option selected disabled>--</option>
                                        </select>
                                    </div>

                                <?php
                                }
                                if (!isset($get_msme->major_business_activity_id) || empty($get_msme->major_business_activity_id)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="major_business_activity_id" class="form-label">Major Business Activity</label>
                                        <select name="major_business_activity_id" class="form-select" id="major_business_activity_id" required>
                                            <option selected disabled>--</option>
                                        </select>
                                    </div>

                                <?php
                                }
                                if (!isset($get_msme->edt_level_id) || empty($get_msme->edt_level_id)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="edt_level_id" class="form-label">Stage of Business Operation</label>
                                        <select name="edt_level_id" class="form-select" id="edt_level_id" required>
                                            <option selected disabled>--</option>
                                        </select>
                                    </div>

                                <?php
                                }
                                if (!isset($get_msme->asset_size_id) || empty($get_msme->asset_size_id)) {
                                ?>
                                    <div class="mb-3">
                                        <label for="asset_size_id" class="form-label">Asset Size</label>
                                        <select name="asset_size_id" class="form-select" id="asset_size_id" required>
                                            <option selected disabled>--</option>
                                        </select>
                                    </div>

                                <?php
                                } ?>

                                <div hidden>
                                    <input value="<?= $msme_id ?>" name="msme_id" />
                                    <input value="<?= $_GET['ref'] ?>" name="ref" />
                                    <input name="msme_completion" />
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right"></i> Take assessment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {

                    $('#updateProfile').modal('show');

                })
            </script>
        <?php
        } else {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="privacyModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="privacyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="privacyModalLabel">Privacy Notice</h1>
                        </div>
                        <div class="modal-body">
                            <p>&emsp;We are committed to respecting your privacy and recognizes the importance of
                                protecting the
                                information collected about you. Personal information that you provided during the registration
                                shall only be processed in relation to the assessment in the system.</p>
                            <p><em><strong>Data Privacy Provision:</strong></em></p>
                            <p>&emsp;Confidentiality: Your responses will be kept strictly confidential. Individual responses
                                will not
                                be shared, and all data will be anonymized before analysis.</p>
                            <p><em><strong>Security Measure:</strong></em></p>
                            <p>&emsp;We have devised security measures to protect your data
                                from
                                unauthorized access or disclosure.</p>
                            <p><em><strong>Anonymity:</strong></em></p>
                            <p>&emsp;Your individual responses will not be linked to your
                                identity. Your
                                privacy will be preserved throughout the survey process.</p>
                            <p>&emsp;By proceeding this assessment, you agree that all personal information you submit in
                                relation to
                                this event shall be protected with reasonable and appropriate measures, and shall only be
                                retained as long as necessary. Thank you for your time and contribution.</p>
                            <hr>
                            <form id="privacy-form">
                                <div class="form-check">
                                    <input class="" type="checkbox" value="" id="i_agree" name="i_agree" required>
                                    <label class="form-check-label" for="i_agree">
                                        I agree
                                    </label>
                                </div>
                                <div hidden>
                                    <input value="<?= $msme_id ?>" name="msme_id" />
                                    <button id="privacyFormBtn"></button>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="privacyFormBtn.click()">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>

    <div class="modal fade" id="success-factor-info" tabindex="-1" aria-labelledby="success-factor-infoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="success-factor-infoLabel">Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul style="list-style-type: circle;">
                        <li><strong>Very High:</strong><br>&emsp;-Identify aspects or criteria where performance or quality is exceptional, exceeding all expectations.
                            <hr>
                        </li>
                        <li><strong>Less than very high:</strong><br>&emsp;-Consider areas where performance or quality falls short of being categorized as <strong>"Very High"</strong> but still demonstrates a high level of proficiency or effectiveness.
                            <hr>
                        </li>
                        <li><strong>Better than High:</strong><br>&emsp;-Evaluate aspects or criteria that surpass the standard level of performance or quality typically considered<strong> "High".</strong></li>
                        <li><strong>High:</strong><br>&emsp;-Assess areas where performance or quality meets the expected standard level of proficiency or effectiveness.
                            <hr>
                        </li>
                        <li><strong>Better than Average:</strong><br>&emsp;-Examine aspects or criteria that outperform what is typically considered average or typical.
                            <hr>
                        </li>
                        <li><strong>Average:</strong><br>&emsp;-Evaluate areas where performance or quality is at the standard level expected, neither exceeding nor falling below.
                            <hr>
                        </li>
                        <li><strong>Better than Low: </strong>Identify aspects or criteria that perform slightly better than what is considered below average or subpar.
                            <hr>
                        </li>
                        <li><strong>Low:</strong><br>&emsp;-Assess areas where performance or quality falls below the expected standard level, indicating room for improvement.
                            <hr>
                        </li>
                        <li><strong>Better than Very Low:</strong><br>&emsp;-Evaluate aspects or criteria that demonstrate some level of performance or quality but still fall below what is considered very poor or inadequate.
                            <hr>
                        </li>
                        <li><strong>Very Low:</strong><br>&emsp;-Identify areas where performance or quality is severely lacking and requires significant improvement to meet even the basic expectations.
                            <hr>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</modals>