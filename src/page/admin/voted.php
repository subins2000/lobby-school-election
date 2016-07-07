<div class="contents">
  <h2>Who Voted Who ?</h2>
  <p>This page gives the information of the votes the voters made.</p>
  <form method="GET" action="<?php Lobby::u("/admin/app/school-election/voted");?>">
    <label>
      <span>Class</span>
      <select name="class">
        <?php
        foreach($this->config['classes'] as $class){
          echo "<option name='$class'>$class</option>";
        }
        ?>
      </select>
    </label>
    <label>
      <span>Division</span>
      <select name="division">
        <?php
        $divs = $this->config['divisions'];
        foreach($divs as $div){
          echo "<option name='$div'>$div</option>";
        }
        ?>
      </select>
    </label><cl/>
    <?php echo CSRF::getInput();?>
    <button class="btn red">Get List</button>
  </form>
  <?php
  $class = Request::getParam("class");
  $div = Request::getParam("division");
  if($class !== null && $div !== null && CSRF::check()){
    $votes = $this->getJSONData("election_votes");
    echo "<h2>List</h2><p>This list shows only the voted voters. You can get the list of <a href='". $this->adminURL ."/didnt-vote'>who didn't vote here</a>.</p><ul>";
    
    $classID = $class . $div;
    $classIDLength = strlen($classID);
    $candidates = $this->EC->getCandidates();
    
    foreach($votes as $id => $vote){
      if(substr($id, 0, $classIDLength) === $classID){
        echo "<li>$id - ";
          array_map(function($item) use ($candidates){
            echo "<b>" . $candidates[$item] . "</b>, ";
          }, $vote);
        echo "</li>";
      }
    }
    echo "</ul>";
  }
  ?>
</div>
