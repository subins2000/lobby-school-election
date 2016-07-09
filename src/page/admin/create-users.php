<?php
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
    
    echo "<table><tbody>";
      echo "<thead><tr><td>Roll Number</td><td>Password</td></tr></thead>";
      for($i = 1; $i < $no + 1;$i++){
        $password = $passwords[$i];
        $data[$i] = $password;
        echo "<tr><td>$i</td><td>$password</td></tr>";
      }
    echo "</tbody></table>";
    $this->removeData("student_passwords");
    $this->saveJSONData("student_passwords", $data);
  }else{
    $passwords = $this->getJSONData("student_passwords");
    if($passwords !== null){
      echo "<h2>Passwords</h2>";
      echo "<table><tbody>";
        echo "<thead><tr><td>Roll Number</td><td>Password</td></tr></thead>";
        foreach($passwords as $i => $password){
          echo "<tr><td>$i</td><td>$password</td></tr>";
        }
      echo "</tbody></table>";
    }
  }
  ?>
</div>
