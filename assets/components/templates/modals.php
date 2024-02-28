<modals>
    <!-- Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="privacyModalLabel">Privacy notice</h1>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minus culpa totam eum nam, quas id amet
                        explicabo officia voluptatem minima maxime necessitatibus consectetur vitae ut facilis
                        temporibus
                        odio incidunt debitis.</p>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aspernatur, aperiam quaerat nostrum in
                        tempore quas voluptas perspiciatis perferendis deleniti expedita eos necessitatibus deserunt
                        laudantium, tenetur qui hic odit velit ullam!</p>
                    <form id="privacy-form">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="i_agree" name="i_agree"
                                required>
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
        $(document).ready(function () {
            <?php
            if ($am_row->privacy != 1) {
                ?>
                $('#privacyModal').modal('show');
                <?php
            }
            ?>
        });
    </script>
</modals>