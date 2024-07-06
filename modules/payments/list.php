<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Select Paymnets </span></h4>
    <div class="add_admin_div ">
        <form id="addadminform" class="row g-3">
            <div class="col-md-3 ml-3">
                <label for="edit_admin_type" class="form-label">Choose Month</label>
                <select class="form-select" id="monthsSelect" name="monthsSelect" required>
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
            <div class="col-md-3">
                <label for="edit_admin_type" class="form-label">Choose Year</label>
                <select class="form-select" id="yearsSelect" name="yearsSelect" required>
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
        </form>
    </div>
    <!-- Responsive Table -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center ">
            <h5 class="card-header">Payments</h5>
            <button id="addadmin" type="button" class=" btn btn-primary m-3" data-bs-toggle="modal"
                data-bs-target="#pModal">
                Add Payments
            </button>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="display table table-bordered table-striped" id="paymentTable">
                <thead>
                    <tr class="text-nowrap">
                        <th>Sr</th>
                        <th>Month/Year</th>
                        <th>Name</th>
                        <th>Hours</th>
                        <th>Rate</th>
                        <th>Current Bill</th>
                        <th>Khati</th>
                        <th>Remaining</th>
                        <th>Total</th>
                        <th>Received</th>
                        <th>Outstandings</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="paymentrecords">
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Table -->
</div>
<!-- / Content -->