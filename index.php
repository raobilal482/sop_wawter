
 <?php
 session_start();
 if(!isset($_SESSION['id'])){
    header("Location: login.php");
}
 include "./inc/header.php";
 include "./inc/nav.php";
 include "./inc/sidebar.php";
 include "modules/dashboard/list.php";
 include "./inc/footer.php";
 ?>
<script src="./modules/dashboard/ajax.js"></script>