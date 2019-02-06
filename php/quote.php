<?php
session_start();
include("config.php");

$sender = $_SESSION['username'];
$quote = filter_var($_POST['quote'], FILTER_SANITIZE_STRING);

$sql = "SELECT balance FROM users where username = '$sender' ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
                $sender_bank = $row['balance'];
            }
        mysqli_free_result($result);
    }
}

$can_bank = $sender_bank - 100000;

if ( $can_bank < 0 ) {
    header("Location: ../index.php");
    die();
}

$sql = "UPDATE users SET quote='$quote', balance='$can_bank' WHERE username='$sender' ";
mysqli_query($link, $sql);

header("Location: ../index.php");
?>
