<?php
session_start();
$_SESSION['login_attempts'] = 0;
header('location:index.php');
?>
