<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin </span></h4>
    <!-- Responsive Table -->
    <div class="card">
        <div class="d-flex justify-content-between">
            <h5 class="card-header">Manage Admins</h5>
            <button class="btn btn-sm btn-primary m-3" data-bs-toggle="modal" data-bs-target="#aModal"
                >Add Admin</button>
        </div>
        <div class="table-responsive text-nowrap p-4">
            <table class="display table table-bordered table-striped" id="recordsTable">
                <thead>
                    <tr class="text-nowrap">
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="showRecords">
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Table -->
</div>
<!-- / Content -->