<?php
if(isset($_POST['id']) && isset($_POST['roll']) && isset($_POST['password'])){
  $roll = $_POST['roll'];
  $voterID = strtoupper($_POST['id']);
  
  $passwords = $this->getJSONData("student_passwords");
  if($this->config["password"] === "1" && $passwords[$roll] != $_POST['password']){
    echo "false";
  }else if($this->EC->didVote($voterID) == false){
    $_SESSION['election-validated'] = "true";
    echo "true";
  }else{
    echo "voted";
  }

}
