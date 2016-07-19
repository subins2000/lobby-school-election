<?php
$class = Request::getParam("class");
$div = Request::getParam("division");
?>
<div class="contents">
  <h2>Who Voted ?</h2>
  <p>This page gives the information of who all voted.</p>
  <form method="GET" action="<?php Lobby::u("/admin/app/school-election/voted");?>">
    <label>
      <span>Class</span>
      <select name="class">
        <?php
        foreach($this->config['classes'] as $arClass){
          echo "<option name='$class' ". ($arClass === $class ? "selected='selected'" : "") .">$arClass</option>";
        }
        ?>
      </select>
    </label>
    <label>
      <span>Division</span>
      <select name="division">
        <?php
        $divs = $this->config['divisions'];
        foreach($divs as $arDiv){
          echo "<option name='$div' ". ($arDiv === $div ? "selected='selected'" : "") .">$arDiv</option>";
        }
        ?>
      </select>
    </label><cl/>
    <?php echo CSRF::getInput();?>
    <button class="btn red">Get List</button>
  </form>
  <?php
  
  if($class !== null && $div !== null && CSRF::check()){
    $votes = $this->getJSONData("election_votes");
    echo "<h2>List</h2><p>This list shows only the voted voters in <b>ascending order of time</b>. You can get the list of <a href='". $this->adminURL ."/didnt-vote'>who didn't vote here</a>.</p><ul>";
    
    $classID = $class . $div;
    $classIDLength = strlen($classID);
    $candidates = $this->EC->getCandidates();
    
    $classVotes = array();
    foreach($votes as $id => $vote){
      if(substr($id, 0, $classIDLength) === $classID){
        $classVotes[] = $id;
      }
    }
    
    if(empty($classVotes))
      echo "<li>Nobody has voted</li";
    
    foreach($classVotes as $id){
      echo "<li>$id</li>";
    }
    echo "</ul>";
  }
  ?>
</div>
