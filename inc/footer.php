            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                    <div>
                        <a href="#" class="footer-link me-4">Documentation</a>
                        <a href="#" class="footer-link me-4">Support</a>
                    </div>
                </div>
            </footer>
            <!-- / Footer -->
            <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
            </div>
            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
            </div>
            <!-- / Layout wrapper -->
            <!-- Core JS -->
            <!-- build:js assets/vendor/js/core.js -->
            <script src="../assets/vendor/libs/jquery/jquery.js"></script>
            <script src="../assets/vendor/libs/popper/popper.js"></script>
            <script src="../assets/vendor/js/bootstrap.js"></script>
            <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/datatables@1.10.18/media/js/jquery.dataTables.min.js"></script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    $(document).ready(function(){
        getsetting();
    function getsetting(){
        $.ajax({
            url:"modules/settings/action.php",
            type:"POST",
            data:{
            action : 'getsettings'
            },
            success:function(response){
                data = JSON.parse(response);
                data.forEach(setting => {
                    if(setting.setting_name = 'logo'){
                        $('#logoinput').val(setting.setting_value);
                        $('#logo').html(setting.setting_value);
                    } 
                });
            }
        }) 
    }
    getadmininfo();
    function getadmininfo(){
        $.ajax({
            url:"modules/admin-profile/action.php",
            type:"POST",
            data:{
                action:"getadmininfo"
            },
            success:function(response){
                data = JSON.parse(response);
                console.log(data)
                $('#name').val(data.admin_name);
                $('#email').val(data.admin_email);
                $('#phoneNumber').val(data.admin_mobile);
                $('#address').val(data.admin_address);
                $('#additional_details').val(data.admin_details);
                $('#userName').text(data.admin_name);
            }
        })
    }
    
})
</script>

            <script src="../assets/vendor/js/menu.js"></script>
            <!-- endbuild -->
            <!-- Vendors JS -->
            <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
            <!-- Main JS -->
            <script src="../assets/js/main.js"></script>
            <!-- Page JS -->
            <script src="../assets/js/dashboards-analytics.js"></script>
            <!-- Place this tag in your head or just before your close body tag. -->
             </body>
</html>