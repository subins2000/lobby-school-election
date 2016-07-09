<?php
$this->addScript("config.js");
$this->addStyle("config.css");
?>
<div class="contents">
  <h1>Configure Election</h1>
  <p>To know how to do the configuration, <a href="https://github.com/subins2000/lobby-school-election#configuration" target="_blank" class="btn red">read this</a>.</p>
  <?php
  $type = Request::postParam("type");
  $strength = Request::postParam("strength");
  $votes = Request::postParam("votes");
  
  if($type !== null && $strength !== null && $votes !== null && CSRF::check()){    
    $classes = Request::postParam("classes");
    $divs = Request::postParam("divs");
    $ableToChoose = Request::postParam("votes");
    
    if(($type === "single" || $type === "multiple") && !empty($classes)){
      $submitConfig = array(
        "type" => $type,
        "classes" => $classes,
        "divisions" => $divs,
        "max-strength" => $strength,
        "able-to-choose" => $ableToChoose,
        "password" => isset($_POST["password"]) ? "1" : "0"
      );
      $newConfig = $submitConfig + $this->config;
      $newConfig = array_replace($newConfig, $submitConfig);
      
      $this->saveJSONData("config", $newConfig);
    }
    echo sss("Saved", "The configuration has been saved.");
    $this->config = $newConfig;
  }
  ?>
  <form action="<?php echo Lobby::u();?>" method="POST">
    <label>
      <span><a href="https://github.com/subins2000/lobby-school-election#type" target="_blank">Election Type</a></span>
      <select name="type">
        <option value="single">Normal Election</option>
        <option value="multiple" <?php if($this->config["type"] === "multiple"){echo "selected='selected'";}?>>Boys & Girls</option>
      </select>
    </label>
    <label>
      <span><a href="https://github.com/subins2000/lobby-school-election#able-to-choose" target="_blank">Number of Votes</a></span>
      <input type="number" name="votes" placeholder="How may votes can the student make ?"  value="<?php echo $this->config["able-to-choose"];?>" />
    </label>
    <label>
      <span><a href="https://github.com/subins2000/lobby-school-election#max-strength" target="_blank">Maximum Strength</a></span>
      <input type="number" name="strength" value="<?php echo $this->config["max-strength"];?>" />
    </label>
    <div>
      <span><a href="https://github.com/subins2000/lobby-school-election#password" target="_blank">Password For Voters</a></span><cl/>
      <label>
        <input type="checkbox" name="password" <?php if($this->config["password"] === "1"){echo "checked='checked'";}?> />
        <span>Password</span>
      </label>
    </div>
    <div id="classes" class="row" style="margin-top: 10px;">
      <span class="col s12"><a href="https://github.com/subins2000/lobby-school-election#classes" target="_blank">Classes</a><a id="add"></a></span>
      <?php
      foreach($this->config["classes"] as $class){
      ?>
        <div class="valign-wrapper col s6">
          <input type="number" name="classes[]" value="<?php echo $class;?>" class="valign" />
          <a id="remove" class="valign"></a>
        </div>
      <?php
      }
      ?>
    </div>
    <div id="divisions" class="row">
      <span class="col s12"><a href="https://github.com/subins2000/lobby-school-election#divisions" target="_blank">Divisions</a><a id="add"></a></span>
      <?php
      foreach($this->config["divisions"] as $div){
      ?>
        <div class="valign-wrapper col s6">
          <input type="text" name="divs[]" value="<?php echo $div;?>" class="valign" />
          <a id="remove" class="valign"></a>
        </div>
      <?php
      }
      ?>
    </div>
    <?php echo CSRF::getInput();?>
    <button class="btn green">Save</button>
  </form>
</div>
