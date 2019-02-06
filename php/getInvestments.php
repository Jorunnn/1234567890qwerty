<div class="panel">
<?php include_once("fixer.php");

$sql = "SELECT amount, profit FROM investments where username = '$username' ORDER BY id DESC LIMIT 0, 1";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){

                $amount = strrev(implode(".", str_split((string)strrev($row['amount']), "3")));
                
                $profit = strrev(implode(".", str_split((string)strrev($row['profit']), "3")));

                if ($profit == "0") {
                  echo "<p class='text-send'>" . $amount . "P stake, " . "fund lost.</p>";
                } else {
                  echo "<p class='text-received'>" . $amount . "P stake, " . $profit . " profit.</p>";
                }
            }
        mysqli_free_result($result);
    }
}
?>
</div>