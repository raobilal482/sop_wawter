<?php
// include "../../inc/config.php";
include "../../inc/functions.php";
// $obj  = new db();
$obj = new func();
if (isset($_POST['action']) && $_POST['action'] == 'getusers') {
    $result = $obj->dashboard('water_users');
    echo json_encode($result[0]['len']);
}

if(isset($_POST['action']) && $_POST['action'] == 'getallbill'){
    $result = $obj->getAllbill();
    echo json_encode($result);
}
