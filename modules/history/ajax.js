$(document).ready(function () {
    getusername();
    function getusername() {
        $.ajax({
            url: "modules/history/action.php",
            type: "POST",
            data: { action: "getusers" },
            success: function (response) {
                data = JSON.parse(response);
                $('#usersSelect').append(data);
            }
        });
    }
    getAllrecords();
    function getAllrecords() {
        $.ajax({
            url: "modules/history/action.php",
            type: "POST",
            data: { action: 'historyRecordsauto' },
            success: function (response) {
                var data = JSON.parse(response);
                $('#historyrecords').html(data);
                initializeDataTable();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching all records:', error);
            }
        });
    }
    $('#monthsSelect, #yearsSelect, #usersSelect').change(function () {
        $('#reportTable').DataTable().destroy();
        $('#historyrecords').empty();
        $.ajax({
            url: "modules/history/action.php",
            type: "POST",
            data: $('#historyform').serialize() + '&action=historyRecords',
            success: function (response) {
                var data = JSON.parse(response);
                $('#historyrecords').html(data);
                initializeDataTable();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching filtered records:', error);
            }
        });
    });
    function initializeDataTable() {
        $('#reportTable').DataTable({
            layout: {
                topStart: {
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                }
            }
        });
    }
})
