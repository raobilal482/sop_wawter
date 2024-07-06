
<!-- Modal -->
<div class="modal fade" id="uModal" tabindex="-1" aria-labelledby="aModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="addModalLabel">Add Users</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div id="errordiv" style="background:red">
            </div>
            <!-- Start of form -->
            <div class="add_user_div ">
               <form id="adduserform" class="row g-3">
                  <div class="col-md-12">
                     <input type="number" hidden name="add_id" id="add_id">
                     <label for="edit_admin_name" class="form-label">Enter Name</label>
                     <input type="text" class="form-control" id="user_name" name="user_name"  required>
                     <div class="invalid-feedback">
                        Enter Name.
                     </div>
                  </div>
                  <div class="col-md-12">
                     <label for="user_user_mobile" class="form-label">Mobile</label>
                     <input type="number" class="form-control" id="user_mobile" name="user_mobile" required>
                     <div class="invalid-feedback">
                        Enter Cell Number.
                     </div>
                  </div>
                  <div class="col-md-12">
                     <label for="user_user_mobile" class="form-label">Add working Hours</label>
                     <input type="number" class="form-control" id="user_hours" name="hours" required>
                     <div class="invalid-feedback">
                        Enter working hours.
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <div class="col-4">
                        <button class="btn btn-primary" type="submit" id="adduserbtn">Add Users</button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- End of form -->
         </div>
      </div>
   </div>
</div>





