<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Expenses </span></h4>
    <div class="add_history_div ">
        <form id="expensesform" class="row g-3">
            <div class="col-md-3 ml-3">
                <label for="edit_history_type" class="form-label">Choose Month</label>
                <select class="form-select" id="monthsSelect" name="monthsSelect" required>
                    <option value="*" selected>All</option>
                    <option value="1">January</option>
                    <option value="2">Feb</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <div class="invalid-feedback">
                    Select Month.
                </div>
            </div>
            <div class="col-md-3" id="tablediv">
                <label for="edit_history_type" class="form-label">Choose Year</label>
                <select class="form-select" id="yearsSelect" name="yearsSelect" required>
                <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>
                    <option value="2035">2035</option>
                    <option value="2036">2036</option>
                    <option value="2037">2037</option>
                    <option value="2038">2038</option>
                    <option value="2039">2039</option>
                    <option value="2040">2040</option>
                    <option value="2041">2041</option>
                    <option value="2042">2042</option>
                    <option value="2043">2043</option>
                    <option value="2044">2044</option>
                    <option value="2045">2045</option>
                    <option value="2046">2046</option>
                    <option value="2047">2047</option>
                    <option value="2048">2048</option>
                    <option value="2049">2049</option>
                    <option value="2050">2050</option>
                </select>
                <div class="invalid-feedback">
                    Select Year.
                </div>
            </div>
        </form>
    </div>
    <!-- Responsive Table -->
    <div class="card">
        <div class="d-flex justify-content-justify">
            <h5 class="card-header">All Expenses</h5>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="display table table-bordered table-striped" id="expensesReportTable">
                <thead>
                    <tr class="text-nowrap">
                        <th>Sr</th>
                        <th>Month/Year</th>
                        <th>Electricity Bill</th>
                        <th>Operator Salary</th>
                        <th>Manage Salary</th>
                        <th>Light Expenses</th>
                        <th>Other Expenses</th>
                        <th>Total Expenses</th>
                    </tr>
                </thead>
                <tbody id="expensesrecords">
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Table -->
</div>
<!-- / Content -->