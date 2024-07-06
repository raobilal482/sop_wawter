<?php
session_start();
if(!isset($_SESSION['id'])){
header("Location: login.php");
}
include "inc/header.php";
include "inc/nav.php";
include "inc/sidebar.php";
define("APP_START", 1);
include "modules/users/list.php";
include "modules/users/add_user.php";
include "modules/users/edit_user.php";
include "inc/footer.php";
?>
<script src="modules/users/ajax.js"></script>