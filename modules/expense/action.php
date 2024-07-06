<?php
include "../../inc/functions.php";
$obj = new func();
$expenses = "";
if (isset($_POST['action']) && $_POST['action'] == 'addexpenses') {
    $month = $_POST['month'];
    $year = $_POST['year'];
    $bill = $_POST['ebill'];
    $osalary = $_POST['opsalary'];
    $msalary = $_POST['msalary'];
    $lexpenses = $_POST['lexpenses'];
    $oexpenses = $_POST['oexpenses'];
    $totalexpenses = $bill + $osalary + $msalary + $lexpenses + $oexpenses;
    $values = [
        'month_expenses' => $month,
        'year_expenses' => $year,
        'electricity_bill' => $bill,
        'operator_salary' => $osalary,
        'manager_salary' => $msalary,
        'light_expenses' => $lexpenses,
        'other_expenses' => $oexpenses,
        'total_expenses' => $totalexpenses,
    ];
    $alreadyAddedPayment = $obj->checkAlreadyAddedPayments('water_expenses', $month, $year);
    if (!empty($alreadyAddedPayment)) {
        echo json_encode(false);
    } else {
        $result = $obj->insertRecords('water_expenses', $values, null, null);
        echo json_encode(true);
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'getexpenses') {
    $a = 1;
    $getpay = $obj->getAllRecords('water_expenses', null, false, false);
    foreach ($getpay as $expense) {
        $expenses .= '<tr>
                    <td>' . $a . '</td>
                    <td >' . $expense['month_expenses'] . '/' . $expense['year_expenses'] . '</td>
                    <td>' . $expense['electricity_bill'] . '</td>
                    <td>' . $expense['operator_salary'] . '</td>
                    <td>' . $expense['manager_salary'] . '</td>
                    <td>' . $expense['light_expenses'] . '</td>
                    <td>' . $expense['other_expenses'] . '</td>
                    <td>' . $expense['total_expenses'] . '</td>
                    <td> <button id="' . $expense['id'] . '"  class="editexepenses btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exeModal">
                    Edit
                </button> </td>
                    </tr>';
        $a++;
    }
    echo json_encode($expenses);
}
if (isset($_POST['action']) && $_POST['action'] == 'filterexpenses') {
    $month = $_POST['monthsSelect'];
    $year = $_POST['yearsSelect'];
    $a = 1;
    $getpay = $obj->getexpensesforHistory('water_expenses', $month, $year);
    foreach ($getpay as $expense) {
        $expenses .= '<tr>
        <td>' . $a . '</td>
        <td >' . $expense['month_expenses'] . '/' . $expense['year_expenses'] . '</td>
        <td>' . $expense['electricity_bill'] . '</td>
        <td>' . $expense['operator_salary'] . '</td>
        <td>' . $expense['manager_salary'] . '</td>
        <td>' . $expense['light_expenses'] . '</td>
        <td>' . $expense['other_expenses'] . '</td>
        <td>' . $expense['total_expenses'] . '</td>
        <td> <button id="' . $expense['id'] . '"  class="editexepenses btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exeModal">
        Edit
    </button> </td>
        </tr>';
        $a++;
    }
    echo json_encode($expenses);
}
if (isset($_POST['action']) && $_POST['action'] == 'geteditexpenses') {
    $editexpensesid = $_POST['edit_id'];
    $editexpenses = $obj->getSingleRecord('water_expenses', $editexpensesid, null, null);
    echo json_encode($editexpenses);
}
if (isset($_POST['action']) && $_POST['action'] == 'updateexpenses') {
    $id = $_POST['hiddenid'];
    $month = $_POST['exemonth'];
    $year = $_POST['exeyear'];
    $bill = $_POST['exebill'];
    $osalary = $_POST['oexepsalary'];
    $msalary = $_POST['mexesalary'];
    $lexpenses = $_POST['lexeexpenses'];
    $oexpenses = $_POST['oexeexpenses'];
    $updatevalues = [
        'month_expenses' => $month,
        'year_expenses' => $year,
        'electricity_bill' => $bill,
        'operator_salary' => $osalary,
        'manager_salary' => $msalary,
        'light_expenses' => $lexpenses,
        'other_expenses' => $oexpenses,
    ];
    $expensesresult = $obj->updaterecords('water_expenses', $updatevalues, $id);
    echo json_encode($updatevalues);
}
