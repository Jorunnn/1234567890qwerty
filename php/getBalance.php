<?php include_once("fixer.php");
  $sql = "SELECT balance FROM users where username = '$username' ";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){

            $balance = strrev(implode(".", str_split((string)strrev($row['balance']), "3")));

            echo "<p>Balance: " . $balance . "P</p>";
            echo "<title>Netbank " . $balance . "P </title>";
          }
        mysqli_free_result($result);
    }
  }
?>
