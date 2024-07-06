<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: login.php");
}
include "inc/header.php";
include "inc/sidebar.php";
define("APP_START", 1);
include "modules/balance/list.php";
include "inc/footer.php";
?>
<script src="modules/balance/ajax.js"></script>