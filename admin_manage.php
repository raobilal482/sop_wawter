<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: login.php");
}
include "inc/header.php";
include "./inc/nav.php";
include "inc/sidebar.php";
include "modules/admin/list.php";
include "modules/admin/add_admin.php";
include "modules/admin/edit_admin.php";
include "inc/footer.php";
?>
<script src="modules/admin/ajax.js"></script>
<script src=""></script>