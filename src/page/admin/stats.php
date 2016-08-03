<div class="contents">
	<h1>Statistics</h1>
	<p>See the <b>live</b> results of the election</p>
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
      $candidates = $this->EC->getCandidates($class, $div);
      $votes = $this->EC->count($candidates);
    }else{
      $candidates = $this->EC->getCandidates();
      $votes = $this->EC->count($candidates);
    }
    
    $this->addScript("chart.min.js");
  ?>
    <h2>Graph</h2>
    <center>
      <canvas id="chart" width="600" height="400"></canvas>
    </center>
    <script>
      lobby.load(function(){
        var ctx = $("#workspace #chart")[0].getContext("2d");
        var myChart = new Chart(ctx).Bar({
          labels: <?php echo json_encode(array_keys($votes));?>,
          datasets: [{
              label: '# of Votes',
              data: <?php echo json_encode(array_values($votes));?>,
              borderWidth: 1
          }]
        });
      });
    </script>
    <h2>Standings</h2>
    <?php
    if($this->config["type"] === "single"){
    ?>
      <ol>
        <?php
        foreach($votes as $name => $votes){
          echo "<li>$name - $votes</li>";
        }
        ?>
      </ol>
    <?php
    }else if($this->config["type"] === "class"){
    ?>
      <ol>
        <?php
        foreach($votes as $name => $votes){
          echo "<li>$name - $votes</li>";
        }
        ?>
      </ol>
    <?php
    }else{
    ?>
      <div class="row">
        <div class="col m6">
          <h4>Boys</h4>
          <ol>
            <?php
            $candidates = $this->EC->getCandidates("male");
            $votes = $this->EC->count($candidates);
            
            foreach($votes as $name => $votes){
              echo "<li>$name - $votes</li>";
            }
            ?>
          </ol>
        </div>
        <div class="col m6">
          <h4>Girls</h4>
          <ol>
            <?php
            $candidates = $this->EC->getCandidates("female");
            $votes = $this->EC->count($candidates);
            
            foreach($votes as $name => $votes){
              echo "<li>$name - $votes</li>";
            }
            ?>
          </ol>
        </div>
      </div>
    <?php
    }
  }
  ?>
</div>
