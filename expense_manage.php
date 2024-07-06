<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: login.php");
}
include "inc/header.php";
include "inc/nav.php";
include "inc/sidebar.php";
include "modules/expense/list.php";
include "modules/expense/add_expense.php";
include "modules/expense/edit_expense.php";
include "inc/footer.php";
?>
<script src="modules/expense/ajax.js"></script>