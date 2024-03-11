<modals>
    <!-- Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                            <input class="form-check-input" type="checkbox" value="" id="i_agree" name="i_agree" required>
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
    <script>
        $(document).ready(function() {
            <?php
            if ($am_row->privacy != 1) {
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
</modals>