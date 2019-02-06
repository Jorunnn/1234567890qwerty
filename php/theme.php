<?php
session_start();
include("config.php");

$sender = $_SESSION['username'];
$theme = $_POST['theme'];

$sql = "UPDATE users SET theme='$theme' WHERE username='$sender' ";
if(mysqli_query($link, $sql)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

header("Location: ../index.php");
?>
