$(document).ready(function() {
   
    showExpensesRecords();

    function showExpensesRecords() {
     
        $.ajax({
            url: "modules/expense_history/action.php",
            type: "POST",
            data: $('#expensesform').serialize() + '&action=getexpenses',
            success: function(response) {
                var data = JSON.parse(response);
                $("#expensesrecords").html(data);

                // Initialize DataTable
                $('#expensesReportTable').DataTable({
                    // DataTable options and configurations
                });
            }
        });
    }

    $('#monthsSelect, #yearsSelect').on('change', function() {
        $('#expensesReportTable').DataTable().destroy();

        showExpensesRecords();
    });
});
