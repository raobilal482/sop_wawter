<?php
include "../../inc/functions.php";
$obj = new func();
$admin_data = "";
if (isset($_POST['action']) && $_POST['action'] == 'getRecords') {
    $admin_records = $obj->getAllRecords('panel_admin');
    $sn = 1;
    foreach ($admin_records as $admin_rec) {
        $admin_data .= '
        <tr class="gradeX">
            <td>' . $sn . '</td>
            <td>' . $admin_rec["admin_name"] . '</td>
            <td>' . $admin_rec["admin_email"] . '</td>
            <td>' . $admin_rec["admin_mobile"] . '</td>
            <td> <button class="btn" data-bs-toggle="modal" data-bs-target="#eModal" id="editbtn" data-id="' . $admin_rec['id'] . '"><box-icon type="solid" class="bx bx-edit" name="edit-alt"></box-icon></button>
            <button class="btn " id="deletebtn" data-id="' . $admin_rec['id'] . '"><i class="bx bx-trash "></i></button></td>
        </tr>';
        $sn++;
    }
    echo json_encode($admin_data);
    exit();
}
if (isset($_POST['action']) && $_POST['action'] == 'insertRecords') {
    $admin_type = $_POST['admin_role'];
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];
    $admin_mobile = $_POST['admin_mobile'];
    $password = $_POST['password'];
    if ($admin_type == "" || $admin_name == "" || $admin_email == "" || $admin_mobile == "" || $password == "") {
        die(json_encode(['status' => false, 'error' => 'Data not inserted']));
    }
    $values = ['admin_type' => $admin_type, 'admin_name' => $admin_name, 'admin_email' => $admin_email, 'admin_mobile' => $admin_mobile, 'password' => $password];
    $result=$obj->insertRecords('panel_admin', $values,$admin_email,$password);
    if($result){
        echo json_encode(['status' => true, 'mesg' => 'Data inserted succefully']);
    }else{
        echo json_encode(['status' => false, 'error' => 'UserName Already Exists']);
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'editRecords') {
    $id = $_POST['editId'];
    $fresult = $obj->getSingleRecord('panel_admin', $id);
    echo json_encode($fresult);
}
if (isset($_POST['action']) && $_POST['action'] == 'deleteRecord') {
    $did = $_POST['deleteId'];
    $dresult = $obj->deleteRecord('panel_admin', $did);
    echo json_encode($dresult);
}
if (isset($_POST['action']) && $_POST['action'] == 'updateRecords') {
    $id = $_POST['edits_id'];
    $admin_type = $_POST['edit_admin_role'];
    $admin_name = $_POST['edit_admin_name'];
    $admin_email = $_POST['edit_admin_email'];
    $admin_mobile = $_POST['edit_admin_mobile'];
    $password = $_POST['edit_password'];
    $updatevalues = ['admin_type' => $admin_type, 'admin_name' => $admin_name,
        'admin_email' => $admin_email, 'admin_mobile' => $admin_mobile, 'password' => $password];
    $updateresult = $obj->updaterecords('panel_admin', $updatevalues, $id);
    echo json_encode($updateresult);
}
