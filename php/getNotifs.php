<div class="panel"><p style="font-weight: bold;">Transactions:</p><div class="flex">
<?php include_once("fixer.php");
$sql = "SELECT amount, receiver, comment, sender, timestamp FROM transfers where sender = '$username' OR receiver = '$username' ORDER BY id DESC LIMIT 0, 12";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){

                $amount = $row['amount'];
                $amount_text = (string)$amount;
                $amount_text_rev = strrev($amount_text);
                $arr = str_split($amount_text_rev, "3");
                $amount_new_text = implode(".", $arr);
                
                echo "<div class='list-container' title='" . $row['timestamp'] . "'>";
                if ($username == $row['sender']) {
                  echo "<p class='text-send'>" . strrev($amount_new_text) . "P &#129050; " . $row['receiver'] . "</p>
                  <p>" . $row['comment'] . "</p><p style='font-size:10px; float:right;'>" . $row['timestamp'] . "</p>";
                } else if ($username == $row['receiver']) {
                  echo "<p class='text-received'>" . $row['sender'] . " &#129050; " . strrev($amount_new_text) . "P</p>
                  <p>" . $row['comment'] . "</p><p style='font-size:10px; float:right;'>" . $row['timestamp'] . "</p>";
                }
                echo "</div>";
            }
        mysqli_free_result($result);
    }
}
?>
</div>
</div>
