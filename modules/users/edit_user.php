<?php
   // if(!defined("APP_START")) die("No Direct Access");
   ?>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Edid User Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="errordiv" style="background:red">
                </div>
                <!-- Start of form -->
                <div class="add_admin_div ">
                    <form id="edituserform" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        <div class="col-md-12">
                            <input type="number" hidden name="edit_id" id="edit_id">
                            <label for="edit_user_name" class="form-label">Enter Name</label>
                            <input type="text" class="form-control" id="edit_user_name" name="edit_user_name" required>
                            <div class="invalid-feedback">
                                Enter Name.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_admin_mobile" class="form-label">Mobile</label>
                            <input type="number" class="form-control" id="edit_user_mobile" name="edit_user_mobile"
                                required>
                            <div class="invalid-feedback">
                                Enter Cell Number.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_password" class="form-label">Working Hours</label>
                            <input type="text" class="form-control" id="edit_user_hours" name="edit_user_hours"
                                required>
                            <div class="invalid-feedback">
                                Enter Hours.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div class="col-2">
                                <button class="btn btn-primary" type="submit" id="updateuserbtn">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of form -->
            </div>
        </div>
    </div>
</div>