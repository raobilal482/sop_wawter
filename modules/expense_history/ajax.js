$(document).ready(function() {
	showexpensesRecords();
    function showexpensesRecords() {
        $.ajax({
            url: "modules/expense_history/action.php",
            type: "POST",
            data: $('#expensesform').serialize() + '&action=getexpenses',
            success: function(response) {
                data = JSON.parse(response);
                $("#expensesrecords").html(data);
                $('#expensesReportTable').DataTable({
                    layout: {
						topStart: {
							buttons: ['copy', 'excel', 'pdf', 'colvis']
						}
					}
                });
            }
        });
    }
	$('#monthsSelect, #yearsSelect').on('change', function() {
		showexpensesRecords();
	});
})
