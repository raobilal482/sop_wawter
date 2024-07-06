<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: login.php");
}
include "inc/header.php";
include "inc/nav.php";
include "inc/sidebar.php";
define("APP_START", 1);
include "modules/expense_history/list.php";
include "inc/footer.php";
?>
<script src="modules/expense_history/ajax.js"></script>