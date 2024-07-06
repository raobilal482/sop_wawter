$(document).ready(function() {
    $('#login_submit').on("click", function(e) {
        e.preventDefault();
        $.ajax({
            url: "modules/login/action.php",
            type: "POST",
            data: $('#loginForm').serialize() + '&action=checklogin',
            success: function(response) {
                console.log(response);
                if (response === 'false') {
                    $('#loginerror').fadeIn(400);
                } else {
                    $('#loginerror').fadeOut(400);
                    window.location.href = 'index.php';
                }
            }
        });
    });
});
