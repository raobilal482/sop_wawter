<?php
session_start();
include __DIR__ . '/../../inc/functions.php';
$obj = new func();
if (isset($_POST['action']) && $_POST['action'] == 'checklogin') {
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $login = $obj->getSingleRecord('panel_admin', null, $email, $password);
    if ($login !== false) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $login['id'];
        $_SESSION['name'] = $login['admin_name'];
        $_SESSION['email'] = $login['admin_email'];
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
}
?>
