<?php
session_start();
if(isset($_SESSION['id'])){
  header("Location: index.php");
}
include "./modules/login/login_do.php";
include "./modules/login/action.php";
?>
<script src="./modules/login/ajax.js"></script>