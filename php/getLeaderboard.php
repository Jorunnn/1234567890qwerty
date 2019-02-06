<div class='panel'><p class="table-title"><b>Top Users</b></p><table class='leaderboard'>
<?php include_once("fixer.php");
$num = 0;
$sql = "SELECT username, balance, marker, quote FROM users WHERE balance > 999 ORDER BY balance DESC ";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){

          $balance = $row['balance'];
          
          if ($balance >= 999) {
          $balance_new_text = strrev(implode(".", str_split((string)strrev($balance), "3")));
          
          $back = "";
              if (strlen($balance) >= "4"){
                  $back = "K";
                  $balance_new_text = substr($balance_new_text, 0, -2);
              }
              if (strlen($balance) >= "7"){
                  $back = "M";
                  $balance_new_text = substr($balance_new_text, 0, -4);
              }
              if (strlen($balance) >= "10"){
                  $back = "B";
                  $balance_new_text = substr($balance_new_text, 0, -4);
              }
              if (substr($balance, -1) == "0"){
                $balance_new_text = substr($balance_new_text, 0, -2);
              }
                
                $num++;
                echo "<tr>";
                echo "<td style='width:130px;'>" . $row['marker'] . " " . $row['username'] . ": </td>";
                echo "<td>" . $balance_new_text .  $back . "</td>";
                if ($num < 4) { echo "<td style='padding-left:30px;'>" . $row['quote'] . "</td>";}
                echo "</tr>";
              }
          }
        mysqli_free_result($result);
    }
}
?>
</table></div>

