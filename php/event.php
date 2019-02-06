<?php
session_start();
include("config.php");

$sender = $_SESSION['username'];

$sql = "SELECT balance, event, luck FROM users where username = '$sender' ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
                $event = $row['event'];
                $luck = $row['luck'];
                $sender_bank = $row['balance'];
            }
        mysqli_free_result($result);
    }
}

if ( $event == 0 ) { header( "Refresh:0; url=../index.php", true, 303); die(); }

if ($luck==0) {
  $amount = rand(50000,75000);
} else {
  $amount = rand(1000,10000);
}

$new_sender_bank = $sender_bank + $amount;
$new_event = $event - 1;

$luck = rand(0,29);
$sql = "UPDATE users SET balance='$new_sender_bank', event='$new_event', luck='$luck' WHERE username='$sender' ";
mysqli_query($link, $sql);

$sender = "Netbank";
$receiver = $_SESSION['username'];
$comment = "To a good start of the week!";

$sql = "INSERT INTO transfers (sender, amount, receiver, comment) VALUES ('$sender', '$amount', '$receiver', '$comment')";
mysqli_query($link, $sql);

header( "Refresh:0; url=../index.php", true, 303);
?>
