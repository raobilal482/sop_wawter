<?php
include "../../inc/functions.php";
$obj = new func();
$users_data = "";
if (isset($_POST['action']) && $_POST['action'] == 'addpayments') {
    $hours = $_POST['hours'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $alreadyAddedPayment = $obj->checkAlreadyAddedPayments('water_user_payments',$month,$year);
    if(!empty($alreadyAddedPayment)){
        echo json_encode(false);
    }else{
        $result = $obj->payments($month,$year,$hours);
        echo json_encode(true);
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'getpayments') {
    $month = $_POST['cmonth'];
    $year = $_POST['cyear'];
    $getpay = $obj->showpayments($month,$year);
    echo json_encode($getpay);
}
if (isset($_POST['action']) && $_POST['action'] == 'getselectedpayments') {
    $month = $_POST['selectedmonth'];
    $year = $_POST['selectedyear'];
    $getpay = $obj->showpayments($month,$year);
    echo json_encode($getpay);
}
if (isset($_POST['action']) && $_POST['action'] == 'geteditpayment') {
$editpaymentid = $_POST['theid'];
$editpayment = $obj->getSingleRecord('water_user_payments',$editpaymentid,null,null);
// $getdate = $obj->date_convert($editpayment['received_date']);
// $values = ['miscvalues'=>$editpayment,'date'=>$getdate];
$values = ['miscvalues'=>$editpayment];
echo json_encode($values);
}
if(isset($_POST['action']) && $_POST['action'] == 'editkhati'){
    $khatiid = $_POST['khatiid'];
$editkhatipayment = $obj->getSingleRecord('water_user_payments',$khatiid,null,null);
echo json_encode($editkhatipayment);
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == 'updatepayments' || $action == 'addkhati') {
        if ($action == 'updatepayments') {
            $id = $_POST['hiddenpaymentid'];
        } elseif ($action == 'addkhati') {
            $id = $_POST['khatiid'];
        } else {
            echo json_encode(['error' => 'Invalid action']);
            exit; 
        }
        $singlerow = $obj->getSingleRecord('water_user_payments', $id, null, null);
        if ($action == 'addkhati') {
            $khativalue = $_POST['khativalue'];
            $updatevalues = ['water_khati' => $khativalue];
            $result = $obj->updaterecords('water_user_payments', $updatevalues, $id);
            // echo json_encode("khati added");
        }
        if($action == 'updatepayments'){
        $user_id = $_POST['user_id'];
        $received_amount = $_POST['received_amount'];
        // $date = $_POST['received_date'];
        $outstandings = $singlerow['water_total_bill'] - $received_amount;
        $updatevalues = [
            'received_amount' => $received_amount,
            'outstandings' => $outstandings,
            // 'received_date' => $date
        ];
        $obj->updaterecords('water_user_payments', $updatevalues, $id);
        $singlerow = $obj->getSingleRecord('water_user_payments', $id, null, null);
        $alldata = $obj->updateallrecords('water_user_payments', $singlerow['user_id'], $singlerow['payment_month'], $singlerow['payment_year']);
        $remaining = $singlerow['remaining'];
        $nextMonthRemaining = $remaining;
        foreach ($alldata as $data) {
            $watercurrentbill = $data['water_hours'] * $data['water_rate'];
            $watertotalbill = $watercurrentbill + $nextMonthRemaining + $data['water_khati'];
            $outstandings = $watertotalbill - $data['received_amount'];
            $updatevalues = [
                'remaining' => $nextMonthRemaining,
                'water_current_bill' => $watercurrentbill,
                'water_total_bill' => $watertotalbill,
                'outstandings' => $outstandings,
            ];
            $nextMonthRemaining = $outstandings;
            $obj->updaterecords('water_user_payments', $updatevalues, $data['id']);
        }
        echo json_encode($alldata);
    }
    }
}
