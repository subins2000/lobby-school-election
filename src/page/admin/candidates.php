<?php
if(isset($_POST['update_male-candidates']) || isset($_POST['update_female-candidates'])){
  $candidates = isset($_POST['update_male-candidates']) ? $this->getJSONData("male-candidates") : $this->getJSONData("female-candidates");
  
  foreach($_POST['candidates'] as $id => $value){
    $candidates[$id] = $value;
  }
  
  if(isset($_POST['update_male-candidates'])){
    $this->saveJSONData("male-candidates", $candidates);
  }else{
    $this->saveJSONData("female-candidates", $candidates);
  }
}

if( isset($_POST['add_male-candidates']) || isset($_POST['add_female-candidates']) ){
  $data = array();
  $i = isset($_POST['add_male-candidates']) ? 0 : 50;
  
  foreach($_POST['candidates'] as $candidate_name){
    $data[$i] = $candidate_name;
    $i++;
  }
  if(isset($_POST['add_female-candidates'])){
    // Girls
    $this->saveJSONData("female-candidates", $data);
  }else{
    // Boys
    $this->saveJSONData("male-candidates", $data);
  }
}
?>
<div class="contents">
  <h2>Boys</h2>
  <p>Use the below form to change details of the <b>Boys</b> Candidates</p>
  <?php
  if($this->EC->isElection("male")){
    $candidates = $this->getJSONData("male-candidates");
    echo "<form method='POST'>";
      foreach($candidates as $id => $candidate){
        echo "<div class='item'>";
          echo "<input type='text' size='30' name='candidates[{$id}]' value='{$candidate}' />";
        echo "</div>";
      }
      echo "<div class='item'>";
        echo "<button name='update_male-candidates' class='btn red'>Update Boys' Details</button>";
      echo "</div>";
    echo "</form>";
  }else{
  ?>
    <form method="POST">
      <?php
      for($i = 0; $i < $this->config['male-candidates']; $i++){
        echo "<div class='item'>";
          echo "<input name='candidates[]' placeholder='Candidate # ". ($i + 1) ."' />";
        echo "</div>";
      }
      echo "<div class='item'>";
        echo "<button name='add_male-candidates' class='btn red'>Add Boys Candidates</button>";
      echo "</div>";
      ?>
    </form>
  <?php
  }
  ?>
  <h2>Girls</h2>
  <p>Use the below form to change details of the <b>Girls</b> Candidates</p>
  <?php
  if($this->EC->isElection("female")){
    $candidates = $this->getJSONData("female-candidates");
    
    echo "<form method='POST'>";
      foreach($candidates as $id => $candidate){
        echo "<div class='item'>";
          echo "<input type='text' size='30' name='candidates[{$id}]' value='{$candidate}' />";
        echo "</div>";
      }
      echo "<div class='item'>";
        echo "<button name='update_female-candidates' class='btn red'>Update Girls' Details</button>";
      echo "</div>";
    echo "</form>";
  }else{
  ?>
    <form method="POST">
      <?php
      for($i = 0; $i < $this->config['female-candidates']; $i++){
        echo "<div class='item'>";
          echo "<input name='candidates[]' placeholder='Candidate # ". ($i + 1) ."' />";
        echo "</div>";
      }
      echo "<div class='item'>";
        echo "<button name='add_female-candidates' class='btn red'>Add Girls Candidates</button>";
      echo "</div>";
      ?>
    </form>
  <?php
  }
  ?>
</div>
<style>
#workspace .item{
  margin-top:10px;
}
</style>
