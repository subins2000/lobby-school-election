<div class="contents">
	<h2>Statistics</h2>
	<p>See the <b>live</b> results of the election</p>
	<h3>Candiate Result</h3>
  <script>
    $(window).load(function(){
      lobby.app.ajax("stats-img.php", {}, function(base64){
        $("img#stats").attr("src", "data:image/png;base64," + base64);
      });
    });
  </script>
	<img id="stats" alt="Graph Image Loading..." style='max-width: 100%;' />
	<h3>Standings</h3>
	<h4>Boys</h4>
	<ol>
    <?php
    $candidateNames = $this->getJSONData("male-candidates");
    $votes = $this->EC->count($candidateNames);
    
    foreach($votes as $name => $votes){
      echo "<li>$name - $votes</li>";
    }
    ?>
	</ol>
	<h4>Girls</h4>
	<ol>
    <?php
    $candidateNames = $this->getJSONData("female-candidates");
    $votes = $this->EC->count($candidateNames);
    
    foreach($votes as $name => $votes){
      echo "<li>$name - $votes</li>";
    }
    ?>
	</ol>
  <?php
  $students = $this->getJSONData("election_votes");
  if(is_array($students)){
  ?>
    <h3>Voters Details</h3>
    <p>The last 10 persons that have voted :</p>
    <ol>
  <?php
    $students = array_keys($students);
    $students = array_chunk(array_reverse($students), 10);
    $students = $students[0];
    
    foreach($students as $student){
      echo "<li>$student</li>";
    }
    echo "</ol>";
  }
  ?>
</div>
