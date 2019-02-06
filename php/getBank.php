<?php include_once("fixer.php");
  $sql = "SELECT bank, rate FROM users where username = '$username' ";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){

            $bank = strrev(implode(".", str_split((string)strrev($row['bank']), "3")));
            $rate = (float)$row['rate'] / 100;
            if ( $rate==0 ) { $rate="0.00"; }

            echo "<div class='panel' style='display:flex; justify-content:space-between;'>
            <p>Bank: " . $bank . "P</p>
            <p>" . $rate . "%</p>
            </div>";
          }
        mysqli_free_result($result);
    }
}
?>
