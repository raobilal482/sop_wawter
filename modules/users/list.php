<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users </span></h4>
    <!-- Responsive Table -->
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">Manage Users</h5>
            <button id="addusers" type="button" class="m-3 btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#uModal">
                Add Users
            </button>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="display table table-bordered table-striped" id="usersTable">
                <thead>
                    <tr class="text-nowrap">
                        <th>Sr</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Hours</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="usersrecords">
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Table -->
</div>
<!-- / Content -->