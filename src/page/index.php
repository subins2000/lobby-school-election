<?php
$this->addStyle("style.css");
$this->addScript("election.js");
$_SESSION['election-validated'] = "false";
?>
<script>
lobby.load(function(){
  lobby.app.config = <?php echo json_encode($this->config);?>;
});
</script>
<div class="valign-wrapper">
  <div id="content" class="valign">
    <form action="info.php" id="voterForm">
      <h2>Class</h2>
      <select name="class" <?php if($this->config["disable-class-div-change"] == "1"){ echo "disabled='disabled'";} ?>>
        <?php
        foreach($this->config['classes'] as $class){
          echo "<option value='$class' ". ($this->config["default-class"] === $class ? "selected='selected'" : "") .">$class</option>";
        }
        ?>
      </select>
      <h2>Division</h2>
      <select name="division" <?php if($this->config["disable-class-div-change"] == "1"){ echo "disabled='disabled'";} ?>>
        <?php
        $divs = $this->config['divisions'];
        foreach($divs as $div){
          echo "<option value='$div' ". ($this->config["default-division"] === $div ? "selected='selected'" : "") .">$div</option>";
        }
        ?>
      </select>
      <h2>Roll Number</h2>
      <input name="roll" type="number" placeholder="Roll Number" autocomplete="off" />
      <?php
      if($this->config["password"] === "1"){
      ?>
        <h2>Password</h2>
        <input name="password" type="password" placeholder="Password" autocomplete="off" />
      <?php
      }
      ?>
      <div style="margin-top: 20px;">
        <button name="submit" class="btn green">Login To Vote</button>
      </div>
    </form>
    <form action="vote.php" id="voteForm">
      <div id="candidates" class="row">
         <?php $this->EC->showCandidates();?>
      </div>
      <button class="btn btn-large green vote" name="vote" value="vote">Vote</button>
      <?php /**<div id="username"></div>*/?>
    </form>
    <div class='thankyou'>
      <h1>Thank You</h1>
      <p>Your vote was entered successfully.</p>
    </div>
    <audio src="<?php echo $this->srcURL;?>/src/audio/beep.mp3" controls="false" id="votedBeep"></audio>
  </div>
  <style>
  body{  
    -webkit-user-select: none;
    -moz-user-select: -moz-none;
    -ms-user-select: none;
    user-select: none;
  }
  </style>
</div>
