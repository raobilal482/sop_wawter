<!-- Modal -->
<div class="modal fade" id="pModal" tabindex="-1" aria-labelledby="aModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addModalLabel">Add Payments</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="errordiv" style="background:red">
                </div>
                <!-- Start of form -->
                <div class="add_admin_div ">
                    <form id="addpaymentform" class="row g-3">
                        <div class="col-md-12">
                            <label for="edit_admin_type" class="form-label">Choose Month</label>
                            <select class="form-select" id="month" name="month" required>
                                <option value="1">January</option>
                                <option value="2">Feb</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">Agust</option>
                                <option value="9">September</option>
                                <option value="10">Oct</option>
                                <option value="11">November</option>
                                <option value="12">December</option>

                            </select>
                            <div class="invalid-feedback">
                                Select Month.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_admin_type" class="form-label">Choose Year</label>
                            <select class="form-select" id="year" name="year" required>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                            <div class="invalid-feedback">
                                Select Year.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="edit_admin_mobile" class="form-label">Enter Payment Hours</label>
                            <input min="0" type="number" class="form-control" id="hours" name="hours" required>
                            <div class="invalid-feedback">
                                Enter Payment.
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div class="col-4">
                                <button class="btn btn-primary" type="submit" id="addpaymentbtn">Add Payment</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End of form -->
            </div>
        </div>
    </div>
</div>