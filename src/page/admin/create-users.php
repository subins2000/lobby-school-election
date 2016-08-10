<?php
$this->addStyle("create-users.css");
$this->setTitle("Generate User Passwords");
?>
<div class="contents">
  <h2>Generate Passwords</h2>
  <p>Use the following form to generate passwords for students to login.</p>
  <p>It is better to change passwords at intervals (30 minutes).</p>
  <form action="<?php echo \Lobby::u();?>" method="POST" clear style="margin-left: 30px;">
    <label>
      <span>Number of Students :</span><cl/>
      <input type="number" name="students" placeholder="Number of Students" value="<?php echo $this->config['max-strength'];?>" /><cl/>
    </label>
    <button class="btn red">Generate</button>
  </form>
  <?php
  if(isset($_POST['students'])){
    echo "<h2>Passwords</h2>";
    $data = array();
    $no = (int) $_POST['students'];
    
    $passwords = range(100, 999);
    shuffle($passwords);
    
    for($i = 1; $i < $no + 1;$i++){
      $password = $passwords[$i];
      $data[$i] = $password;
      echo "<div class='card roll-card'><span class='roll-no'>$i</span> - <span class='pass'>$password</span></div>";
    }
    $this->removeData("student_passwords");
    $this->saveJSONData("student_passwords", $data);
  }else{
    $passwords = $this->getJSONData("student_passwords");
    if(empty($passwords)){
      echo sme("Passwords Not Set", "No passwords have been generated.");
    }else{
      echo "<h2>Passwords</h2>";
      foreach($passwords as $i => $password){
        echo "<div class='roll-card card'><span class='roll-no'>$i</span> - <span class='pass'>$password</span></div>";
      }
    }
  }
  ?>
</div>
