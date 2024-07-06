<?php
include "../../inc/functions.php";
$obj = new func();
$users_data = "";
if (isset($_POST['action']) && $_POST['action'] == 'getusersRecords') {
    $users_records = $obj->getAllRecords('water_users');
    $sn = 1;
    $users_data = array(); 
    foreach ($users_records as $users_rec) {
        $users_data[] = '<tr>'.
                        '<td>'.$sn.'</td>'.
                        '<td>'.$users_rec["user_name"].'</td>'.
                        '<td>'.$users_rec["user_mobile"].'</td>'. 
                        '<td>'.$users_rec["water_hours"].'</td>'. 
                        '<td>'.
                        // '<a href="modules/users/show.php?id='.$users_rec['id'].'" id="showuserbtn_'.$users_rec['id'].'"><i class="bx bx-show"></i>show</a>'.
                        '<button class="btn" data-bs-toggle="modal" data-bs-target="#editModal" id="edituserbtn_'.$users_rec['id'].'" data-id="'.$users_rec['id'].'"><i class="bx bx-edit"></i></button>'.
                        '<button class="btn" id="deleteuserbtn_'.$users_rec['id'].'" data-id="'.$users_rec['id'].'"><i class="bx bx-trash"></i></button>'.
                    '</td>'.
                        '</tr>';
        $sn++;
    }
    echo json_encode($users_data); 
    exit(); 
}
if (isset($_POST['action']) && $_POST['action'] == 'insertusersRecords') {
    $user_name = $_POST['user_name'];
    $user_mobile = $_POST['user_mobile'];
    $hours = $_POST['hours'];
    if ($user_name == "" || $user_mobile == "" || $hours == "") {
        die(json_encode(['status' => false, 'error' => 'Data not inserted']));
    }
    $values = ['user_name' => $user_name, 'user_mobile' => $user_mobile, 'water_hours' => $hours];
    $obj->insertRecords('water_users', $values,null,null);
    echo json_encode(['status' => true, 'mesg' => 'Data inserted succefully']);
}
if(isset($_POST['action']) && $_POST['action'] == "showuserdetails"){
    $id = $_POST['id'];
    $userdata = $obj->getsingleuserdetails($id);
    echo json_encode($userdata);
}
if (isset($_POST['action']) && $_POST['action'] == 'editusersRecords') {
    $id = $_POST['editId'];
    $fresult = $obj->getSingleRecord('water_users', $id);
    echo json_encode($fresult);
}
if (isset($_POST['action']) && $_POST['action'] == 'deleteusersRecord') {
    $did = $_POST['deleteId'];
    $dresult = $obj->deleteRecord('water_users', $did);
    echo json_encode($dresult);
}
if (isset($_POST['action']) && $_POST['action'] == 'updateusersRecords') {
    $id = $_POST['edit_id'];
    $user_name = $_POST['edit_user_name'];
    $user_mobile = $_POST['edit_user_mobile'];
    $hours = $_POST['edit_user_hours'];
    $updatevalues = ['user_name' => $user_name,
        'user_mobile' => $user_mobile, 'water_hours' => $hours];
    $updateresult = $obj->updaterecords('water_users', $updatevalues, $id);
    echo json_encode($updateresult);
}
