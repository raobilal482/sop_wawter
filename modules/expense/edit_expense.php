
<!-- Modal -->
<div class="modal fade" id="exeModal" tabindex="-1" aria-labelledby="aModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-5" id="addModalLabel">Edit Expenses</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <div id="errordiv" style="background:red">
            </div>
            <!-- Start of form -->
            <div class="add_admin_div ">
               <form id="updateexpensesform" class="row g-3">
               <div class="col-md-12">
                     <label for="edit_expenses_type" class="form-label">Choose Month</label>
                     <select class="form-select" id="exemonth" name="exemonth" required>
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
                     <select class="form-select" id="exeyear" name="exeyear" required>
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
                     <label for="edit_admin_mobile" class="form-label">Enter Electricity Bill</label>
                     <input type="number" hidden id="hiddenid" name="hiddenid">
                     <input min="0" type="number" class="form-control" id="exebill" name="exebill" required>
                     <div class="invalid-feedback">
                        Enter Electricity Bill
                     </div>
                  </div>
                  <div class="col-md-12">
                     <label for="edit_admin_mobile" class="form-label">Operator Salary</label>
                     <input min="0" type="number" class="form-control" id="oexepsalary" name="oexepsalary" required>
                     <div class="invalid-feedback">
                        Enter Operator Salary.
                     </div>
                  </div>
                  <div class="col-md-12">
                     <label for="edit_admin_mobile" class="form-label">Manager Salary</label>
                     <input min="0" type="number" class="form-control" id="mexesalary" name="mexesalary" required>
                     <div class="invalid-feedback">
                        Enter Manage Salary.
                     </div>
                  </div>
                  <div class="col-md-12">
                     <label for="edit_admin_mobile" class="form-label">Light Expenses</label>
                     <input min="0" type="number" class="form-control" id="lexeexpenses" name="lexeexpenses" required>
                     <div class="invalid-feedback">
                        Enter Light Expenses.
                     </div>
                  </div>
                 
                  <div class="col-md-12">
                     <label for="edit_admin_mobile" class="form-label">Other Expenses</label>
                     <input min="0" type="number" class="form-control" id="oexeexpenses" name="oexeexpenses" required>
                     <div class="invalid-feedback">
                        Other Expenses
                     </div>
                  </div>
                  <div class="modal-footer ml-5 ">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <div class="col-4 ">
                        <button class="btn btn-primary" type="submit" id="updateebtn">Update</button>
                     </div>
                  </div>
               </form>
            </div>
            <!-- End of form -->
         </div>
      </div>
   </div>
</div>





