<?php
$this->addScript("config.js");
$this->addStyle("config.css");
?>
<div class="contents">
  <h1>Configure Election</h1>
  <p>To know about the configuration, <a href="https://github.com/subins2000/lobby-school-election#configuration" target="_blank">read this</a>.</p>
  <?php
  $type = Request::postParam("type");
  $strength = Request::postParam("strength");
  $votes = Request::postParam("votes");
  
  if($type !== null && $strength !== null && $votes !== null && CSRF::check()){
    $boys = Request::postParam("boys");
    $girls = Request::postParam("girls");
    
    $classes = Request::postParam("classes");
    $divs = Request::postParam("divs");
    $ableToChoose = Request::postParam("votes");
    
    if($type === "single" && !empty($classes)){
      $newConfig = array(
        "type" => "single",
        "classes" => $classes,
        "divisions" => $divs,
        "max-strength" => $strength,
        "male-candidates" => $boys,
        "female-candidates" => $girls,
        "total-candidates" => $boys + $girls,
        "able-to-choose" => $ableToChoose
      ) + $this->config;
      
      $this->saveJSONData("config", $newConfig);
    }else if($type === "multiple" && $boys !== null && $girls !== null){
      $newConfig = array(
        "type" => "multiple",
        "classes" => $classes,
        "divisions" => $divs,
        "max-strength" => $strength,
        "able-to-choose" => $ableToChoose
      ) + $this->config;
      
      $this->saveJSONData("config", $newConfig);
    }
    sss("Saved", "The configuration has been saved.");
    $this->config = $newConfig;
  }
  ?>
  <form action="<?php echo Lobby::u();?>" method="POST">
    <label>
      <span>Election Type</span>
      <select name="type">
        <option value="single">Single</option>
        <option value="multiple" <?php if($this->config["type"] === "multiple"){echo "selected='selected'";}?>>Boys & Girls</option>
      </select>
    </label><cl/>
    <label class="type-multiple-option">
      <span>Number of Boys</span>
      <input type="number" name="boys" value="<?php echo $this->config["female-candidates"];?>" />
    </label>
    <label class="type-multiple-option">
      <span>Number of Girls</span>
      <input type="number" name="girls" value="<?php echo $this->config["male-candidates"];?>" />
    </label>
    <div id="classes" class="row">
      <span class="col s12">Classes <a id="add"></a></span>
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
      <span class="col s12">Divisions <a id="add"></a></span>
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
    <label>
      <span>Maximum Strength</span>
      <input type="number" name="strength" value="<?php echo $this->config["max-strength"];?>" />
    </label>
    <label>
      <span>Number of Votes</span>
      <input type="number" name="votes" placeholder="How may votes can the student make ?"  value="<?php echo $this->config["able-to-choose"];?>" />
    </label>
    <?php echo CSRF::getInput();?>
    <button class="btn green">Save</button>
  </form>
</div>
