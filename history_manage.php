<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: login.php");
}
include "inc/header.php";
include "inc/sidebar.php";
include "modules/history/list.php";
include "inc/footer.php";
?>
<script src="modules/history/ajax.js"></script>