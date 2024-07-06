$(document).ready(function () {
	showusersrecords();
	function showusersrecords() {
		$.ajax({
			url: "modules/users/action.php",
			type: "POST",
			data: {
				action: "getusersRecords"
			},
			success: function (response) {
				var data = JSON.parse(response);
				$("#usersrecords").html(data);
				if ($.fn.DataTable.isDataTable('#usersTable')) {
					$('#usersTable').DataTable().destroy();
				}
				$('#usersTable').DataTable();
			}
		});
	}
	$('#adduserbtn').on("click", function (e) {
		if ($('#adduserform')[0].checkValidity()) {
			e.preventDefault();
			$.ajax({
				url: "modules/users/action.php",
				type: "POST",
				data: $('#adduserform').serialize() + '&action=insertusersRecords',
				success: function (response) {
					data = JSON.parse(response);
					if (data.status != false) {
						Swal.fire({
							icon: 'success',
							title: 'User inserted Successfully',
						})
						$("#uModal").modal('hide');
						$("#adduserform")[0].reset();
						showusersrecords();
						$('#usersTable').DataTable();
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error while inserting new User',
						})
					}
				}
			})
		}
	})
	$(document).on("click", "[id^='edituserbtn_']", function(e) {
		e.preventDefault();
		alert('hello');
		var editid = $(this).data('id');
		$.ajax({
			url: "modules/users/action.php",
			type: "POST",
			data: {
				editId: editid,
				action: "editusersRecords"
			},
			success: function(response) {
				var data = JSON.parse(response);
				$('#edit_id').val(data.id);
				$('#edit_user_name').val(data.user_name);
				$('#edit_user_mobile').val(data.user_mobile);
				$('#edit_user_hours').val(data.water_hours);
				// Assuming you want to show the modal after loading data
				$('#editModal').modal('show');
			}
		});
	});
	
	$('#updateuserbtn').on("click", function (e) {
		e.preventDefault();
		$.ajax({
			url: "modules/users/action.php",
			type: "POST",
			data: $('#edituserform').serialize() + '&action=updateusersRecords',
			success: function (response) {
				var data = JSON.parse(response);
				if (data.status != false) {
					Swal.fire({
						icon: 'success',
						title: "Record Updated Successfully",
					})
					$("#editModal").modal('hide');
					if ($.fn.DataTable.isDataTable('#usersTable')) {
						$('#usersTable').DataTable().destroy();
					}
					showusersrecords();
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Error while updating User',
					})
				}
			},
		})
	});
	$(document).on("click", "[id^='deleteuserbtn_']", function (e) {
		e.preventDefault();
		var deleteid = $(this).data('id');
		if (deleteid != '') {
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				input: 'checkbox',
				inputValue: 0,
				inputPlaceholder: 'Yes, I agree with deleting the records.',
				icon: 'question',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it! <i class="fa fa-arrow-right"></i>',
				inputValidator: (result) => {
					return !result && 'You need to agree with delete option!'
				}
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: "modules/users/action.php",
						type: "POST",
						data: {
							deleteId: deleteid,
							action: "deleteusersRecord"
						},
						success: function (response) {
							Swal.fire({
								icon: 'success',
								title: 'Record Deleted Successfully',
							})
							showusersrecords();
							window.location.reload();
						}
					});
				}
			})
		}
	})
})