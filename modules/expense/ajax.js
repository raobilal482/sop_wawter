$(document).ready(function () {
	showexpensesRecords();
	function showexpensesRecords() {
		$.ajax({
			url: "modules/expense/action.php",
			type: "POST",
			data: { action: 'getexpenses' },
			success: function (response) {
				var data = JSON.parse(response);
				$("#expensesrecords").html(data);
				if ($.fn.DataTable.isDataTable('#expensesTable')) {
					$('#expensesTable').DataTable().destroy();
				}
				$('#expensesTable').DataTable({
					layout: {
						topStart: {
							buttons: ['copy', 'excel', 'pdf', 'colvis']
						}
					}
				});
			}
		});
	}
	$(document).on("click", ".editexepenses", function (e) {
		e.preventDefault();
		var id = $(this).attr("id");
		$.ajax({
			url: "modules/expense/action.php",
			type: "POST",
			data: { edit_id: id, action: 'geteditexpenses' },
			success: function (response) {
				var data = JSON.parse(response);
				$('#hiddenid').val(data.id);
				$('#exemonth').val(data.month_expenses).change();
				$('#exeyear').val(data.year_expenses).change();
				$('#exebill').val(data.electricity_bill);
				$('#oexepsalary').val(data.operator_salary);
				$('#mexesalary').val(data.manager_salary);
				$('#lexeexpenses').val(data.light_expenses);
				$('#oexeexpenses').val(data.other_expenses);
			}
		})
	});
	$('#addexpensesbtn').on("click", function (e) {
		e.preventDefault();
		$.ajax({
			url: "modules/expense/action.php",
			type: "POST",
			data: $('#addexpensesforms').serialize() + '&action=addexpenses',
			success: function (response) {
				var data = JSON.parse(response);
				if (data) {
					Swal.fire({
						icon: 'success',
						title: 'Expenses Added'
					})
				}
				else if (data == false) {
					Swal.fire({
						icon: 'error',
						title: 'Expenses of this month already Exists'
					})
				}
				$("#addexpensesforms")[0].reset();
				$('#exModal').modal('hide');
				showexpensesRecords();
			}
		});
	});
	$('#updateebtn').on("click", function (e) {
		e.preventDefault();
		$.ajax({
			url: "modules/expense/action.php",
			type: "POST",
			data: $('#updateexpensesform').serialize() + '&action=updateexpenses',
			success: function (response) {
				data = JSON.parse(response);
				if (data) {
					Swal.fire({
						icon: 'success',
						title: "Expenses Updated Successfully"
					})
				}
				$("#exeModal").modal('hide');
				showexpensesRecords();
			}
		})
	});
	function filterexpenses() {
		// Destroy the DataTable instance to clear existing data and pagination
		if ($.fn.DataTable.isDataTable('#expensesReportTable')) {
			$('#expensesReportTable').DataTable().destroy();
		}
		
		// Clear the HTML content inside #expensesrecords
		$("#expensesrecords").empty();
	
		// Perform AJAX call to fetch filtered data
		$.ajax({
			url: "modules/expense/action.php",
			type: "POST",
			data: $('#expensesform').serialize() + '&action=filterexpenses',
			success: function(response) {
				// Parse the JSON response
				var data = JSON.parse(response);
	
				// Insert the new HTML content into #expensesrecords
				$("#expensesrecords").html(data);
	
				// Reinitialize DataTable with updated data
				$('#expensesReportTable').DataTable({
					// DataTable initialization options
					// Example layout with buttons
					buttons: ['copy', 'excel', 'pdf', 'colvis'],
					// Add other options as needed
				});
			},
			error: function(xhr, status, error) {
				console.error("Error fetching expenses:", error);
				// Handle AJAX error if needed
			}
		});
	}
	
	// Bind filterexpenses function to change event of #monthsSelect and #yearsSelect
	$('#monthsSelect, #yearsSelect').on('change', function() {
		filterexpenses();
	});
	
})
