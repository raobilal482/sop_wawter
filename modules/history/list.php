   <!--main content start-->
   <section id="main-content">
       <section class="wrapper">
           <!-- page start-->
           <div class="row">
               <div class="col-sm-12">
                   <section class="card">
                       <header class="card-header">
                           Manage History
                           <span class="tools pull-right">
                               <a href="javascript:;" class="fa fa-chevron-down"></a>
                               <a href="javascript:;" class="fa fa-times"></a>
                           </span>
                       </header>
                       <div class="add_history_div ps-3">
                           <form id="historyform" class="row g-3">
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
                                   <label for="edit_history_type" class="form-label">Choose Year</label>
                                   <select class="form-select" id="yearsSelect" name="yearsSelect" required>
                                       <option value="*" selected>All</option>
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
                               <div class="col-md-3">
                                   <label for="edit_users_type" class="form-label">Select Users</label>
                                   <select class="form-select" id="usersSelect" name="usersSelect" required>
                                       <option value="*" selected>All</option>
                                   </select>
                                   <div class="invalid-feedback">
                                       Select Users.
                                   </div>
                               </div>
                           </form>
                       </div>
                       <div class="card-body">
                           <div class="adv-table">
                               <table class="display table table-bordered table-striped" id="reportTable">
                                   <thead>
                                       <tr>
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
                                       </tr>
                                   </thead>
                                   <tbody id="historyrecords">
                                   </tbody>
                                   <tfoot>
                                       <tr>
                                       </tr>
                                   </tfoot>
                               </table>
                           </div>
                       </div>
                   </section>
               </div>
           </div>
       </section>
   </section>

   <!--main content end-->