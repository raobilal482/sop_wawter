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
    $('#settingForm').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"modules/settings/action.php",
            type:"POST",
            data:$('#settingForm').serialize() + '&action=addsettings',
            success:function(response){
                data = JSON.parse(response);
                if(data.setting_name = 'logo'){
                    $('#logoinput').val(data.setting_value);
                    $('#logo').html(data.setting_value);
                }
                if(data){
					Swal.fire({
						icon: "success",
						title: "Logo is Updated",
						showConfirmButton: false,
						timer: 1500
					  });
				}
				if(!data){
					Swal.fire({
						icon: "error",
						title: "Error to update Logo",
						showConfirmButton: false,
						timer: 1500
					  });
				}
            }
        })
    })
})