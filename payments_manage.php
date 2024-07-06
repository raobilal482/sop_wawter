<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: login.php");
}
include "inc/header.php";
include "inc/nav.php";
include "inc/sidebar.php";
include "modules/payments/list.php";
include "modules/payments/add_payments.php";
include "modules/payments/edit_payments.php";
include "modules/payments/addkhati.php";
include "inc/footer.php";
?>
<script src="modules/payments/ajax.js"></script>