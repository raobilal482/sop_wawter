$(document).ready(function () {
    // Initial load of records
    showrecords();

    function showrecords() {
        $.ajax({
            url: "modules/admin/action.php",
            type: "POST",
            data: {
                action: "getRecords"
            },
            success: function (response) {
                var data = JSON.parse(response);
				$('#showRecords').empty();
                $("#showRecords").html(data);
                $('#recordsTable').DataTable();
            },
            error: function (xhr, status, error) {
                console.error("Error fetching records:", error);
                // Optionally handle errors here (e.g., show an error message)
            }
        });
    }

    // Add Admin Button Click Handler
    $('#addAdminbtn').on("click", function (e) {
        if ($('#addadminform')[0].checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "modules/admin/action.php",
                type: "POST",
                data: $('#addadminform').serialize() + '&action=insertRecords',
                success: function (response) {
                    var data = JSON.parse(response);
                    $('.needs-validation').removeClass('was-validated');
                    $("#aModal").modal('hide');
                    $("#addadminform")[0].reset();
                    // Show success message
                    if (data.status != false) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Admin added Successfully',
                        });
                        // Refresh DataTable after adding new admin
                        showrecords();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error while adding new Admin',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error adding admin:", error);
                    // Optionally handle errors here (e.g., show an error message)
                }
            });
        }
    });

    // Edit Admin Button Click Handler
    $(document).on("click", "#editbtn", function (e) {
        e.preventDefault();
        var editid = $(this).data('id');
        $.ajax({
            url: "modules/admin/action.php",
            type: "POST",
            data: {
                editId: editid,
                action: "editRecords"
            },
            success: function (response) {
                var data = JSON.parse(response);
                $('#edits_id').val(data.id);
                $('#edit_admin_name').val(data.admin_name);
                $('#edit_admin_email').val(data.admin_email);
                $('#edit_admin_mobile').val(data.admin_mobile);
                $('#edit_admin_type').val(data.admin_type).change();
                $('#edit_password').val(data.password);
                // Show edit modal
                $("#eModal").modal('show');
            },
            error: function (xhr, status, error) {
                console.error("Error fetching admin details:", error);
                // Optionally handle errors here (e.g., show an error message)
            }
        });
    });

    // Update Admin Button Click Handler
    $('#updateAdminbtn').on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: "modules/admin/action.php",
            type: "POST",
            data: $('#editadminform').serialize() + '&action=updateRecords',
            success: function (response) {
                var data = JSON.parse(response);
                if (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Admin updated successfully',
                    });
                    $("#eModal").modal('hide');
					
                    showrecords();
					
                }
            },
            error: function (xhr, status, error) {
                console.error("Error updating admin:", error);
                // Optionally handle errors here (e.g., show an error message)
            }
        });
    });

    // Delete Admin Button Click Handler
    $(document).on("click", "#deletebtn", function (e) {
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
                    return !result && 'You need to agree with delete option!';
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "modules/admin/action.php",
                        type: "POST",
                        data: {
                            deleteId: deleteid,
                            action: "deleteRecord"
                        },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Admin Deleted Successfully',
                            });
                            // Refresh DataTable after deleting admin
                            showrecords();
                        },
                        error: function (xhr, status, error) {
                            console.error("Error deleting admin:", error);
                            // Optionally handle errors here (e.g., show an error message)
                        }
                    });
                }
            });
        }
    });
});
