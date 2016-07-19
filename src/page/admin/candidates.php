<?php
$this->addStyle("candidates.css");
$this->addScript("candidates.js");

$candidates = $this->EC->getCandidates();

$postCandidates = Request::postParam("candidates");
if($postCandidates !== null){
  $postCandidates = array_filter($postCandidates, function($val){
    return $val["name"] != "";
  });
  $this->removeData("candidates");
  $this->saveJSONData("candidates", $postCandidates);
  $candidates = $this->getJSONData("candidates");
  $saved = 1;
}
?>
<div class="contents">
  <h1>Candidates</h1>
  <form action="<?php echo $this->adminURL;?>/candidates" method="POST">
    <?php
    if(isset($saved))
      echo sss("Saved", "Candidates have been saved");
    
    if($this->config["type"] === "class"){
      $candidatesByClass = array();
      
      if(!empty($candidates)){
        foreach($candidates as $id => $candidate){
          $candidatesByClass[$candidate["class"]][$candidate["division"]][$id] = $candidate;
        }
      }
      
      foreach($this->config["classes"] as $class){
        foreach($this->config["divisions"] as $div){
          /**
           * Last digit is the actual ID of candidate in a class
           * "9867" is for separating the components
           */
          $id = $class . ord($div) . "00";
          
          /**
           * If no candidates in class
           */
          if(!isset($candidatesByClass[$class][$div])){
            $candidatesByClass[$class][$div][$id] = array(
              "name" => null,
              "gender" => null
            );
          }
  ?>
          <div class="addCandidateRows">
            <h3>Class <?php echo $class . $div;?></h3>
            <a id="add"></a>
            <?php
            foreach($candidatesByClass[$class][$div] as $id => $candidate){
            ?>
              <div class="valign-wrapper row" data-id="<?php echo $id;?>" data-class="<?php echo $class;?>" data-div="<?php echo $div;?>">
                <input type="text" class="valign col b8" name="candidates[<?php echo $id;?>][name]" placeholder="Candidate name" value="<?php echo $candidate["name"];?>" />
                <select name="candidates[<?php echo $id;?>][gender]" class="col m2">
                  <option value="m">Male</option>
                  <option value="f" <?php if($candidate["gender"] === "f"){echo "selected='selected'";}?>>Female</option>
                </select>
                <input type="hidden" name="candidates[<?php echo $id;?>][class]" value="<?php echo $class;?>" />
                <input type="hidden" name="candidates[<?php echo $id;?>][division]" value="<?php echo $div;?>" />
                <a id="remove" class="valign col s2"></a>
              </div>
            <?php
            }
            ?>
          </div>
  <?php
        }
      }
    }else if(empty($candidates)){ // Type is either Normal or Boys & Girls
    ?>
      <div class="addCandidateRows">
        <div class="valign-wrapper row" data-id="0">
          <input type="text" class="valign col b8" name="candidates[0][name]" placeholder="Candidate name" />
          <select name="candidates[0][gender]" class="col m2">
            <option value="m">Male</option>
            <option value="f">Female</option>
          </select>
          <a id="remove" class="valign col s2"></a>
        </div>
      </div>
    <?php
    }else{
      foreach($candidates as $id => $candidate){
    ?>
        <div class="addCandidateRows">
          <div class="valign-wrapper row" data-id="<?php echo $id;?>">
            <input type="text" class="valign col b8" name="candidates[<?php echo $id;?>][name]" placeholder="Candidate name" value="<?php echo $candidate["name"];?>" />
            <select name="candidates[<?php echo $id;?>][gender]" class="col m2">
              <option value="m">Male</option>
              <option value="f" <?php if($candidate["gender"] === "f"){echo "selected='selected'";}?>>Female</option>
            </select>
            <a id="remove" class="valign col s2"></a>
          </div>
        </div>
    <?php
      }
    }
    ?>
    <button class="btn green">Save</button>
  </form>
</div>
<script>
lobby.load(function(){
  lobby.app.config = <?php echo json_encode($this->config);?>
});
</script>
