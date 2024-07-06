$(document).ready(function () {
	showpaymentRecords();
	// Function to show payment records for the first time
	function showpaymentRecords() {
		const currentDate = new Date();
		const currentYears = currentDate.getFullYear();
		const currentMonths = currentDate.getMonth() + 1;
		$.ajax({
			url: "modules/payments/action.php",
			type: "POST",
			data: { cmonth: currentMonths, cyear: currentYears, action: 'getpayments' },
			success: function (response) {
				data = JSON.parse(response);
				$("#paymentrecords").html(data);
				$("#paymentTable").DataTable({
					layout: {
						topStart: {
							buttons: ['copy', 'excel', 'pdf', 'colvis']
						}
					}
				});
			}
		});
	}
	function filterPayments() {
		$("#paymentTable").DataTable().destroy();
		var selectPaymentMonth = $('#monthsSelect').val();
		var selectPaymentYear = $('#yearsSelect').val();
		$.ajax({
			url: "modules/payments/action.php",
			type: "POST",
			data: { selectedmonth: selectPaymentMonth, selectedyear: selectPaymentYear, action: 'getselectedpayments' },
			success: function (response) {
				data = JSON.parse(response);
				// console.log(response);
				$('#paymentrecords').html(data);
				$("#paymentTable").DataTable();
			}
		})
	}
	// Add Payment button click event
	$('#addpaymentbtn').on("click", function (e) {
		e.preventDefault();
		$.ajax({
			url: "modules/payments/action.php",
			type: "POST",
			data: $('#addpaymentform').serialize() + '&action=addpayments',
			success: function (response) {
				var data = JSON.parse(response);
				if(data){
					Swal.fire({
						icon: "success",
						title: "Payment is Added",
						showConfirmButton: false,
						timer: 1500
					  });
				}
				if(!data){
					Swal.fire({
						icon: "error",
						title: "Payment is already Added",
						showConfirmButton: false,
						timer: 1500
					  });
				}
				$('#pModal').modal('hide');
				// $('#pModal').reset();
				$('#addpaymentform')[0].reset();
				updatepayments();
				filterPayments();
			}
		});
	});
	$(document).on("click", ".editBtn", function (e) {
		e.preventDefault();
		const paymentid = $(this).attr('id');
		$('#hiddenpaymentid').val(paymentid);
		alert(paymentid);
		$.ajax({
			url: "modules/payments/action.php",
			type: "POST",
			data: { theid: paymentid, action: 'geteditpayment' },
			success: function (response) {
				data = JSON.parse(response);
				// console.log(data.miscvalues.user_id)
				$('#received_amount').val(data.miscvalues.received_amount);
				$('#user_id').val(data.miscvalues.user_id);
				$('#html5-date-input').val(data.date);
			}
		})
	})
	// $( "#received_date" ).datepicker({
	//     dateFormat: "dd-mm-yy",
	// });
	const currentDate = new Date();
	const currentYears = currentDate.getFullYear();
	const currentMonths = currentDate.getMonth() + 1;
	$('#monthsSelect').val(currentMonths);
	$('#yearsSelect').val(currentYears);
	$('#monthsSelect').on("change", function () {
		filterPayments();
	})
	$('#yearsSelect').on("change", function () {
		filterPayments();
	})
	$(document).on("click", "#openkhatibtn", function (e) {
		e.preventDefault();
		var khatiid = $(this).data('id');
		$('#khatiid').val(khatiid);
		$('#hiddenpaymentid').val(khatiid);
		$.ajax({
			url: "modules/payments/action.php",
			type: "POST",
			data: { khatiid: khatiid, action: 'editkhati' },
			success: function (response) {
				console.log(response)
				var data = JSON.parse(response);
				$('#received_amount').val(data.received_amount);
				$('#user_id').val(data.user_id);
				$('#payment_received_status').val(data.payment_received).change();
				$('#received_date').val(data.date);
				$('#payment_remarks').val(data.payment_remarks);
				$('#khati').val(data.water_khati);
				console.log($('#received_amount').val());
				filterPayments();
			}
		})
	})
	$('#addkhatibtn').on("click", async function (e) {
		e.preventDefault();
		var khatiID = $('#khatiid').val();
		var khativalue = $('#khati').val();
		var tValue = $('#tvalue').val();
		await $.ajax({
			url: "modules/payments/action.php",
			type: "POST",
			data: {
				khatiid: khatiID,
				khativalue: khativalue,
				tvalue: tValue,
				action: 'addkhati'
			},
			success: async function (response) {
				$('#khatiform').trigger('reset');
				$("#khatiModal").modal('hide');
				updatepayments();
				showpaymentRecords();
				if(response){
					// Swal.fire({
					// 	icon: "success",
					// 	title: "khati is Added",
					// 	showConfirmButton: false,
					// 	timer: 1500
					//   });
				}
				// window.location.reload(); 
			}
		});
	});
	$('#update_Record').on("click", function (e) {
		e.preventDefault();
		updatepayments();
		// updateforpayments();
		$("#staticBackdrop").modal('hide');
		showpaymentRecords();
		// Swal.fire({
		// 				icon: "success",
		// 				title: "Payment Updated",
		// 				showConfirmButton: false,
		// 				timer: 1500
		// })
	});
	function updatepayments() {
		$.ajax({
			url: "modules/payments/action.php",
			type: "POST",
			data: $('#update_Payment_Form').serialize() + '&action=updatepayments',
			success: function (response) {
				// console.log(response)
				data = JSON.parse(response);
				// console.log(data);
				if (data.status != false) {
					// Toast.fire({
					// 	title: "Record Updated Successfully",
					// 	icon: 'success',
					// })
					$("#paymentrecords").html(data);
					$("#staticBackdrop").modal('hide');
				}
				filterPayments();
			}
		});
	}

})
