<?php
session_start();
include("config.php");

$sender = $_SESSION['username'];
$type = $_POST['type'];

$amount = $_POST['amount'];
$amount = str_replace('-', ' ', $amount);
$amount = str_replace('.', ' ', $amount);
$amount = str_replace(',', ' ', $amount);
$amount = preg_replace("/[^0-9,.]/", "", $amount);
$min = 0;

if ( $amount == "" ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

$sql = "SELECT balance, bank FROM users where username = '$sender' ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
                $sender_balance = $row['balance'];
                $sender_bank = $row['bank'];
            }
        mysqli_free_result($result);
    }
}

if ($type == 1) {
  $can_bank = $sender_bank - $amount;
  $new_sender_balance = $sender_balance + $amount;
  $new_sender_bank = $sender_bank - $amount;
}

if ($type == 2) {
  $can_bank = $sender_balance - $amount;
  $new_sender_balance = $sender_balance - $amount;
  $new_sender_bank = $sender_bank + $amount;
}

if ( $can_bank < 0 ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

if ( $amount == 0 ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

$sql = "UPDATE users SET balance='$new_sender_balance', bank='$new_sender_bank' WHERE username='$sender' ";
if(mysqli_query($link, $sql)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

header("Location: ../index.php");
?>
