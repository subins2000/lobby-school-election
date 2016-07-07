<div class="contents">
	<h2>Who Didn't Vote ?</h2>
	<p>Find the people who didn't vote in a class</p>
	<form method="GET">
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
    </label>
    <label>
      <span>Class Strength</span>
      <input name="roll" type="number" placeholder="Last Roll Number" autocomplete="off" value="<?php echo $this->config["max-strength"];?>" />
    </label>
    <button style="margin-top: 15px;" class="btn red">Find</button>
	</form>
	<?php
  $class = Request::getParam("class");
  $div = Request::getParam("division");
  $roll = Request::getParam("roll");
  
	if($class !== null && $div !== null && $roll !== null){
    if(is_numeric($roll) && $roll <= $this->config['max-strength'] ){
	    echo "<p>People who haven't voted in Class <strong>{$class}</strong> of division <strong>{$div}</strong> :</p>";
	    
      $absent = 0;
	    echo "<ol>";
        for($i=1;$i < (int) $roll + 1;$i ++){
	        $id	= strtoupper($class . $div . $i);
	
	        if($this->EC->didVote($id) == false){
            echo "<li>$id</li>";
            $absent++;
	        }
        }
	    echo "</ol>";
      echo "<table><tbody>";
        echo "<tr>";
	        echo "<td>Total students</td>";
          echo "<td>{$roll}</td>";
        echo "</tr>";
        echo "<tr>";
	        echo "<td>Total students that have voted</td>";
          echo "<td>". ($roll - $absent) ."</td>";
        echo "</tr>";
        echo "<tr>";
	        echo "<td>Total students that didn't vote</td>";
          echo "<td>$absent</td>";
        echo "</tr>";
      echo "</tbdoy></table>";
    }
	}
	?>
</div>
