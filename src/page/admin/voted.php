<?php
$class = Request::getParam("class");
$div = Request::getParam("division");
$roll = Request::getParam("roll");
?>
<div class="contents">
  <h2>Voted List</h2>
  <p>This page gives the information of who all voted and did not.</p>
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
    </label>
    <label>
      <span>Class Strength</span>
      <input name="roll" type="number" placeholder="Last roll number in the class" autocomplete="off" value="<?php echo $this->config["max-strength"];?>" />
    </label><cl/>
    <?php echo CSRF::getInput();?>
    <button class="btn red">Get List</button>
  </form>
  <?php
  
  if($class !== null && $div !== null && CSRF::check()){
    $classID = $class . $div;
    $classIDLength = strlen($classID);
    $candidates = $this->EC->getCandidates();
    
    $voted = array();
    $didntVote = array();
    
    for($i = 1;$i <= $roll;$i++){
      $id	= strtoupper($class . $div . $i);

      if($this->EC->didVote($id)){
        /**
         * Get time of vote
         */
        $voteInfo = $this->getData("voted-$id", true);
        
        $voted[] = array(
          "id" => $id,
          "voted" => $voteInfo["created"]
        );
      }else{
        $didntVote[] = $id;
      }
    }
    
    if(empty($voted)){
      echo ser("Nobody has voted", "Looks like nobody has voted in this class");
    }else{
      echo "<p>The lists below shows voters in <b>ascending order of roll number</b>.</p>";
      echo "<h4>Students who voted</h4><table><thead><th>Voter ID</th><th>When he/she voted</th></thead><tbody>";
      foreach($voted as $vote){
        echo "<tr><td>{$vote['id']}</td><td>{$vote['voted']}</td>";
      }
      echo "</tbody></table>";
      
      echo "<h4>Students who didn't vote</h4><ul class='row collection'>";
      foreach($didntVote as $id){
        echo "<li class='col s2 l2 collection-item'>$id</li>";
      }
      echo "</ul>";
    }
  }
  ?>
</div>
