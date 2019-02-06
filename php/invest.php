<?php
session_start();
include("config.php");

$sender = $_SESSION['username'];
$invest = $_POST['invest'];
$amount = $_POST['amount'];
$amount = max($amount,0);
$amount = str_replace('-', ' ', $amount);
$amount = str_replace('.', ' ', $amount);
$amount = str_replace(',', ' ', $amount);
$amount = preg_replace("/[^0-9,.]/", "", $amount);
$amount = preg_replace('/[^0-9]+/', '', $_POST['amount']);

if ( $invest == 1 ) {
    $chance = rand(0,9);
    $chance = str_replace('1', '0', $chance); $chance = str_replace('2', '0', $chance); $chance = str_replace('3', '0', $chance);
    $chance = str_replace('4', '0', $chance); $chance = str_replace('5', '0', $chance); $chance = str_replace('6', '0', $chance);
    $chance = str_replace('7', '0', $chance); $chance = str_replace('8', '0', $chance);
    $increase = 1.1;}
else if ( $invest == 2 ) {
    $chance = rand(0,1);
    $increase = 2;}
else if ( $invest == 3 ) {
    $chance = rand(0,3);
    $increase = 4;}
else if ( $invest == 4 ) {
    $chance = rand(0,9);
    $increase = 10;}
else if ( $invest == 5 ) {
    $chance = rand(0,49);
    $increase = 50;}

$sql = "SELECT balance, rate FROM users where username = '$sender' ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
                $sender_bank = $row['balance'];
                $rate_old = $row['rate'];
            }
        mysqli_free_result($result);
    }
}


$can_bank = $sender_bank - $amount;
$amount_extra = $amount * $increase;
$new_sender_bank = $sender_bank + $amount_extra - $amount;

if ( $can_bank < 0 ){
    header( "Refresh:0; url=../index.php", true, 303);
    return;
} else if ( $amount == 0 ){
    header( "Refresh:0; url=../index.php", true, 303);
} else if ( $amount == "" ){
    header( "Refresh:0; url=../index.php", true, 303);
} else if( $invest > 5 ){
    header( "Refresh:0; url=../index.php", true, 303);
}

if ( $invest == 1) { $invest = 0.01; }

if ( $chance == 0 ) {
    $amount_extra += "P";
    $marker = "&#9650";
    // $rate = 0.00;
    // $rate = (($invest * $amount) / 10000) + $rate_old;
    // if ( $invest == 0.01) { $invest = 1; }
    // if ( $rate > 10000.00) { $rate = 10000.00; }

    $sql = "UPDATE users SET balance='$new_sender_bank', marker='$marker' WHERE username='$sender' ";
    mysqli_query($link, $sql);
    $sql = "INSERT INTO investments (username, amount, invest, profit) VALUES ('$sender', '$amount', '$invest', '$amount_extra')";
    mysqli_query($link, $sql);
} else {
    $new_sender_bank = $sender_bank - $amount;
    $amount_extra = "0";
    $marker = "&#9660";

    $sql = "UPDATE users SET balance='$new_sender_bank', marker='$marker' WHERE username='$sender' ";
    mysqli_query($link, $sql);
    $sql = "INSERT INTO investments (username, amount, invest, profit) VALUES ('$sender', '$amount', '$invest', '$amount_extra')";
    mysqli_query($link, $sql);
}

header( "Refresh:0; url=../index.php", true, 303);
?>
