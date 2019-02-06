<?php
session_start();
include("config.php");

$sender = $_SESSION['username'];
$receiver = $_POST['name'];
$comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

$amount = $_POST['amount'];
$amount = str_replace('-', ' ', $amount);
$amount = str_replace('.', ' ', $amount);
$amount = str_replace(',', ' ', $amount);
$amount = preg_replace("/[^0-9,.]/", "", $amount);
$min = 0;

if ( $sender == $receiver ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

if ( $amount == "" ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

$sql = "SELECT balance FROM users where username = '$sender' ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
                $sender_bank = $row['balance'];
            }
        mysqli_free_result($result);
    }
}

$sql = "SELECT balance FROM users where username = '$receiver' ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
                $receiver_bank = $row['balance'];
            }
        mysqli_free_result($result);
    }  else { $receiver_bank = "none"; }
}

$new_sender_bank = (float)$sender_bank - (float)$amount;
$new_receiver_bank = (float)$receiver_bank + (float)$amount;
$can_bank = $sender_bank - $amount;

if ( $can_bank < 0 ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

if ( $amount == 0 ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

if ( $receiver_bank == "none" ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

if ( $receiver == "" ) {
    header( "Refresh:0; url=../index.php", true, 303);
    die();
}

if ( $new_sender_bank < $min ) {
    echo "You can't transfer that amount!";
    header( "Refresh:3; url=../index.php", true, 303);
    die();
}

$sql = "UPDATE users SET balance='$new_sender_bank' WHERE username='$sender' ";
if(mysqli_query($link, $sql)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

$sql = "UPDATE users SET balance='$new_receiver_bank' WHERE username='$receiver' ";
if(mysqli_query($link, $sql)){
    echo "Records were updated successfully.";
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

date_default_timezone_set('Europe/Amsterdam');
$stamp = date("Y/m/d") . " " . date("H:i");

if ( $comment == "" ) {
    $sql = "INSERT INTO transfers (sender, amount, receiver, timestamp) VALUES ('$sender', '$amount', '$receiver', '$stamp')";
    if(mysqli_query($link, $sql)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
} else {
    $sql = "INSERT INTO transfers (sender, amount, receiver, comment, timestamp) VALUES ('$sender', '$amount', '$receiver', '$comment', '$stamp')";
    if(mysqli_query($link, $sql)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
}
// header("Location: ../index.php");
?>
