<?php
include_once("php/config.php");
include_once("php/models.php");

// DEMO CODE, SIMULEERD POST
// $_POST['id'] = 1;
// $_POST['quiz_id'] = 1;

$_POST['request'] = 1;
$request = $_POST['request'];

if ($request==0) {
  $id = $_POST['id'];
  
  $sql = "SELECT username, points FROM users where id = '$id' ";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $username = $row['username'];
            $points = $row['points'];
          }
        mysqli_free_result($result);
    }
  }

  $myObj = new User;
  $myObj->name = $username;
  $myObj->points = $points;
  $myObj->id = $id;
  $myJSON = json_encode($myObj);
  echo $myJSON;
  
} else if ($request==1) {
  $id = $_POST['id'];
  $quiz_id = $_POST['quiz_id'];
  
  $sql = "SELECT question FROM cards where id = '$id' AND quiz_id = '$quiz_id' ";
  if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $question = $row['question'];
          }
        mysqli_free_result($result);
    }
  }
  
  $num = 1;
  while ($num <= 2) {
    $sql = "SELECT content, correct FROM answers where card_id = '$id' ";
    if($result = mysqli_query($link, $sql)){
      if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_array($result)){
              ${"content" . $num} = $row['content'];
              ${"correct" . $num} = $row['correct'];
            }
          mysqli_free_result($result);
      }
    }
    $num++;
  }

  $myObj = new Card;
  $myObj->question = $question;
  $myObj->answers = (object) [
    'answer1' => (object) [
      'content' => $content1,
      'correct' => $correct1,
    ],
    'answer2' => (object) [
      'content' => $content2,
      'correct' => $correct2,
    ]
  ];

  $myJSON = json_encode($myObj);
  echo $myJSON;
}
?>