<?php
include "../../inc/functions.php";
$obj = new func();
if(isset($_POST['action']) && $_POST['action']=='addsettings'){
    $logo = $_POST['logoinput'];
    $data = [
        'settings_name' => 'logo',
        'setting_value' => $logo
    ];
    $response = $obj->updaterecords('settings',$data,1);
    echo json_encode($response);
}
if(isset($_POST['action']) && $_POST['action']=='getsettings'){
    $response = $obj->getAllRecords('settings');
    echo json_encode($response);
}
?>