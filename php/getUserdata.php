<?php include_once("fixer.php");
  $sql = "SELECT theme, quote, notification FROM users where username = '$username' ";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $theme = $row['theme'];
            $quote = $row['quote'];
            $notification = $row['notification'];
          }
        mysqli_free_result($result);
    }
}
if ($notification==1) {
  $sql = "UPDATE users SET notification=0 WHERE username='$username' ";
  mysqli_query($link, $sql);
  header("Location: info.php");
}
?>
