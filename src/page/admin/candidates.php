<?php
$this->addStyle("candidates.css");
$this->addScript("candidates.js");

$candidates = $this->EC->getCandidates();

$postCandidates = Request::postParam("candidates");
if($postCandidates !== null){
  $this->removeData("candidates");
  $this->saveJSONData("candidates", $postCandidates);
  $candidates = $this->getJSONData("candidates");
}
?>
<div class="contents">
  <h1>Candidates</h1>
  <form action="<?php echo $this->adminURL;?>/candidates" method="POST">
    <a id="add"></a>
    <?php
    if(empty($candidates)){
    ?>
      <div class="valign-wrapper row" data-id="0">
        <input class="valign col b8" name="candidates[0][name]" placeholder="Candidate name" />
        <select name="candidates[0][gender]" class="col m2">
          <option value="m">Male</option>
          <option value="f">Female</option>
        </select>
        <a id="remove" class="valign col s2"></a>
      </div>
    <?php
    }else{
      foreach($candidates as $id => $candidate){
    ?>
        <div class="valign-wrapper row" data-id="<?php echo $id;?>">
          <input class="valign col b8" name="candidates[<?php echo $id;?>][name]" placeholder="Candidate name" value="<?php echo $candidate["name"];?>" />
          <select name="candidates[<?php echo $id;?>][gender]" class="col m2">
            <option value="m">Male</option>
            <option value="f" <?php if($candidate["gender"] === "f"){echo "selected='selected'";}?>>Female</option>
          </select>
          <a id="remove" class="valign col s2"></a>
        </div>
    <?php
      }
    }
    ?>
    <button class="btn green">Save</button>
  </form>
</div>
