<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
if (!isset($link)) { include("config.php"); }
$username = $_SESSION['username'];
?>