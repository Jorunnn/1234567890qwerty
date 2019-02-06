<?php include_once("fixer.php");
  $sql = "SELECT event, luck FROM users where username = '$username' ";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          if ( $row['event'] != 0 ) {
              
              if ($row['luck']==0) {
                echo "
                <form action='functions/event.php' method='get'>
                    <button type='submit' class='super-event' title='You have " . $row['event'] . " crates left.'>Golden Crate</button>
                </form>";
              } else {
                echo "
                <form action='functions/event.php' method='get'>
                    <button type='submit' class='event' title='Get Free Coins!''>" . $row['event'] . " Crates</button>
                </form>";
              }
              
            }
          }
        mysqli_free_result($result);
    }
}
?>
