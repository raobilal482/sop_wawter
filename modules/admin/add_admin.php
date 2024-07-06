<!-- Modal -->
<div class="modal fade" id="aModal" tabindex="-1" aria-labelledby="aModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add add Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="errordiv" style="background:red">
                </div>
                <!-- Start of form -->
                <div class="add_admin_div ">
                    <form id="addadminform" class="row g-3">
                        <div class="col-md-12">
                            <input type="number" hidden name="edit_id" id="edit_id">
                            <label for="edit_admin_name" class="form-label">Enter Name</label>
                            <input type="text" class="form-control" id="admin_name" name="admin_name" required>
                            <div class="invalid-feedback">
                                Enter Name.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_admin_email" class="form-label">Enter Email</label>
                            <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                            <div class="invalid-feedback">
                                Enter Gmail.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_admin_mobile" class="form-label">Mobile</label>
                            <input type="number" class="form-control" id="admin_mobile" name="admin_mobile" required>
                            <div class="invalid-feedback">
                                Enter Cell Number.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_admin_type" class="form-label">Choose Role</label>
                            <select class="form-select" id="admin_type" name="admin_role" required>

                                <option value="0">Visiter</option>

                                <option value="1">Admin</option>
                            </select>
                            <div class="invalid-feedback">
                                Select Role.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                            <div class="invalid-feedback">
                                Enter Password.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div class="col-4">
                                <button class="btn btn-primary" type="submit" id="addAdminbtn">Add Admin</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of form -->
            </div>
        </div>
    </div>
</div>