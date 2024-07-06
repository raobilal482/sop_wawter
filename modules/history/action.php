<?php
include "../../inc/functions.php";
$obj = new func();
if (isset($_POST['action']) && $_POST['action'] == 'getusers') {
    $username = "";
    $getusers = $obj->getAllRecords('water_users', null, null);
    foreach ($getusers as $users) {
        $username .= '<option value = ' . $users['id'] . '>' . $users['user_name'] . '</option>';
    }
    echo json_encode($username);
    exit;
}
if (isset($_POST['action']) && $_POST['action'] == 'historyRecords') {
    $month = $_POST['monthsSelect'];
    $year = $_POST['yearsSelect'];
    $users = $_POST['usersSelect'];
    $getusers = $obj->getRecordsforHistory('water_user_payments', $month, $year, $users);
    $historydata = "";
    $sr = 1;
    foreach ($getusers as $user) {
        $historydata .= '<tr>
                        <td>' . $sr . '</td>
                            <td>' . $user['payment_month'] . '/' . $user['payment_year'] . '</td>
                            <td>' . $user['user_name'] . '</td>
                            <td>' . $user['water_hours'] . '</td>
                            <td>' . $user['water_rate'] . '</td>
                            <td>' . $user['water_current_bill'] . '</td>
                            <td>' . $user['water_khati'] . '</td>
                            <td>' . $user['remaining'] . '</td>
                            <td>' . $user['water_total_bill'] . '</td>
                            <td>' . $user['received_amount'] . '</td>
                            <td>' . $user['outstandings'] . '</td>
                        </tr>';
        $sr++;
    }
    echo json_encode($historydata);
    exit;
}
if (isset($_POST['action']) && $_POST['action'] == 'historyRecordsauto') {
    $getusers = $obj->getRecordsforHistory('water_user_payments', '*', '*', '*');
    $historydata = "";
    $sr = 1;
    foreach ($getusers as $user) {
        $historydata .= '<tr>
                        <td>' . $sr . '</td>
                            <td>' . $user['payment_month'] . '/' . $user['payment_year'] . '</td>
                            <td>' . $user['user_name'] . '</td>
                            <td>' . $user['water_hours'] . '</td>
                            <td>' . $user['water_rate'] . '</td>
                            <td>' . $user['water_current_bill'] . '</td>
                            <td>' . $user['water_khati'] . '</td>
                            <td>' . $user['remaining'] . '</td>
                            <td>' . $user['water_total_bill'] . '</td>
                            <td>' . $user['received_amount'] . '</td>
                            <td>' . $user['outstandings'] . '</td>
                        </tr>';
        $sr++;
    }
    echo json_encode($historydata);
    exit;
}
