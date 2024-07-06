<?php
session_start();
include "functions.php";
$_SESSION=[];
session_unset();
session_destroy();
header("Location:../login.php");
?>