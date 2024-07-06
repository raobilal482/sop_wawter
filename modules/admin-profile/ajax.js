$(document).ready(function(){
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
                
            }
        })
    }
    $('#profileUpdate').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"modules/admin-profile/action.php",
            type:'POST',
            data:$('#profileUpdate').serialize()+'&action=updateadminprofile',
            succes:function(response){
                data = JSON.parse(response);
                if(data){
                    Swal.fire({
                        icon:'success',
                        title:'Profile Updated Successfully'
                    })
                }
            }
        })
    })
})