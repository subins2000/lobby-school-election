<?php
if(isset($_POST['id']) && isset($_POST['roll']) && isset($_POST['password'])){
  $roll = $_POST['roll'];
  $voterID = strtoupper($_POST['id']);
  
  $passwords = unserialize($this->getData("student_passwords"));
  if($passwords[$roll] == $_POST['password']){
    if($this->EC->didVote($voterID) == false){
      $_SESSION['election-validated'] = "true";
      echo "true";
    }else{
      echo "voted";
    }
  }else{
    echo "false";
  }

}
