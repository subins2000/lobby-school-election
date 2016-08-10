<div class="contents">
	<h1>Statistics</h1>
	<p>See the <b>live</b> results of the election.</p>
  <?php
  $showResults = false;
  
  if($this->config["type"] === "class"){
    $class = Request::getParam("class");
    $div = Request::getParam("division");
  ?>
    <form action="<?php echo $this->adminURL;?>/stats" method="GET">
      <label>
        <span>Class</span>
        <select name="class">
          <?php
          foreach($this->config['classes'] as $arClass){
            echo "<option value='$arClass' ". ($arClass === $class ? "selected='selected'" : "") .">$arClass</option>";
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
            echo "<option value='$arDiv' ". ($arDiv === $div ? "selected='selected'" : "") .">$arDiv</option>";
          }
          ?>
        </select>
      </label>
      <button style="margin-top: 15px;" class="btn red">Get Results</button>
    </form>
  <?php
    if($class !== null && $div !== null)
      $showResults = true;
  }else{
    $showResults = true;
  }
  
  if($showResults){
    if($this->config["type"] === "class"){
      $cands = $this->EC->getCandidates($class, $div);
    }else{
      $cands = $this->EC->getCandidates();
    }
    
    /**
     * Sort candidates by votes
     */
    usort($cands, function($cand1, $cand2){
      return $cand1["votes"] < $cand2["votes"];
    });
    
    /**
     * BG color of bar graph according to votes
     */
    $bgColors = array(
      0 => "#FFD700", // Gold
      1 => "#C0C0C0", // Silver
      2 => "#CD7F32" // Bronze
    );
    
    $names = array();
    $votes = array();
    
    $i = 0;
    foreach($cands as $cand){
      $names[] = $cand["name"];
      $votes[] = $cand["votes"];
      if($i > 2)
        $bgColors[] = "#000";
      $i++;
    }
    
    if(empty($votes)){
      echo sme("No Data", "Looks like no one has voted. It's lonely here...");
    }else{
      $this->addStyle("stats.css");
      $this->addScript("chart.min.js");
      
      if($this->config["type"] === "class")
        echo "<p>Showing results of <b>$class $div</b> :</p>";
  ?>
      <h3>Standings</h3>
      <?php
      if($this->config["type"] === "single" || $this->config["type"] === "class"){
        $i = 1;
        foreach($cands as $cand){
          echo "<div class='card cand-card ". (
            $i === 1 ? "first" : (
              $i === 2 ? "second" : (
                $i === 3 ? "third" : ""
              )
            )
          ) ."'><span class='cand-name'>{$cand['name']}</span> - <span class='cand-votes'>{$cand['votes']}</div>";
          $i++;
        }
      }else{
      ?>
        <div class="row">
          <div class="col m6">
            <h4>Boys</h4>
            <?php
            $cands = $this->EC->getCandidates("male");
            
            $i = 1;
            foreach($cands as $cand){
              echo "<div class='card cand-card ". (
                $i === 1 ? "first" : (
                  $i === 2 ? "second" : (
                    $i === 3 ? "third" : ""
                  )
                )
              ) ."'><span class='cand-name'>{$cand['name']}</span> - <span class='cand-votes'>{$cand['votes']}</div>";
              $i++;
            }
            ?>
          </div>
          <div class="col m6">
            <h4>Girls</h4>
            <?php
            $cands = $this->EC->getCandidates("female");
            
            $i = 1;
            foreach($cands as $cand){
              echo "<div class='card cand-card ". (
                $i === 1 ? "first" : (
                  $i === 2 ? "second" : (
                    $i === 3 ? "third" : ""
                  )
                )
              ) ."'><span class='cand-name'>{$cand['name']}</span> - <span class='cand-votes'>{$cand['votes']}</div>";
              $i++;
            }
            ?>
          </div>
        </div>
      <?php
      }
      ?>
      <h3>Graph</h3>
      <center>
        <canvas id="chart" width="600" height="400"></canvas>
      </center>
      <script>
        lobby.load(function(){
          var ctx = $("#workspace #chart")[0].getContext("2d");
          var myChart = new Chart(ctx).Bar({
            labels: <?php echo json_encode($names);?>,
            datasets: [{
                label: '# of Votes',
                data: <?php echo json_encode($votes);?>,
                fillColor: <?php echo json_encode($bgColors);?>,
                borderWidth: 1
            }],
            yAxisMinimumInterval: 1,
            responsive: true
          });
        });
      </script>
  <?php
    }
  }
  ?>
</div>
