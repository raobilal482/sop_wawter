<!-- Modal -->
<div class="modal fade" id="khatiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Water Khati</h1>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="khatiform">
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="validationCustom05" class="form-label">Enter Water Khati</label>
                        <input type="number" class="form-control" id="khati" name="khati" required>
                        <input type="number" class="form-control" id="khatiid" name="khatiid" hidden>

                        <div class="invalid-feedback">
                            Enter Khati
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" id="addkhatibtn" class="btn btn-primary">Add Khati</button>
            </div>
        </div>
    </div>
</div>