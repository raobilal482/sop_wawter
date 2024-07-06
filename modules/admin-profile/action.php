<?php
session_start();
include "../../inc/functions.php";
$obj = new func();
if(isset($_POST['action']) && $_POST['action']== 'getadmininfo'){
    $id = $_SESSION['id'];
    $fresult = $obj->getSingleRecord('panel_admin', $id);
    if($fresult){
        echo json_encode($fresult);
    }
    else{
        return false;
    }
}
if(isset($_POST['action']) && $_POST['action']=='updateadminprofile'){
    $admin_name = $_POST['name'];
    $admin_email = $_POST['email'];
    $admin_mobile = $_POST['phoneNumber'];
    $admin_address = $_POST['address'];
    $admin_details = $_POST['additional_details'];
    $id = $_SESSION['id'];
    $updatevalues = [
        'admin_name' => $admin_name,
        'admin_email' => $admin_email,
        'admin_mobile' => $admin_mobile,
        'admin_address' => $admin_address,
        'admin_details' => $admin_details
    ];
    $response = $obj->updaterecords('panel_admin',$updatevalues,$id);
    echo json_encode($response);
}



?>