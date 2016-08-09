<?php
namespace Lobby\App\school_election;

class Election {

  private $candidates = array();
  private $maleCandidates = array();
  private $femaleCandidates = array();
 	
  /**
   * @param $app Instance of Lobby\App
   */
 	public function __construct($app){
    $this->config = $app->config;
    $this->app = $app;
    
    $this->candidates = $this->app->getJSONData("candidates");
    return true;
 	}
 	
 	public function showCandidates($class = null, $div = null){
    if($this->config["type"] === "multiple"){
      /**
       * Boys Section
       */
      echo "<div id='boys'>";
        echo "<h2>Boys</h2>";
        echo $this->makeCandidatesHTML($this->getCandidates("male"));
      echo "</div>";
      
      /**
       * Girls Section
       */
      echo "<div id='girls'>";
        echo "<h2>Girls</h2>";
        echo $this->makeCandidatesHTML($this->getCandidates("female"));
      echo "</div>";
    }else if($this->config["type"] === "class"){
      if($class === null || $div === null)
        return "";
      return $this->makeCandidatesHTML($this->getCandidates($class, $div));
    }else{
      echo $this->makeCandidatesHTML($this->getCandidates());
    }
 	}
 	
 	public function makeCandidatesHTML($data){
 		$html = "";
    if($this->isElection()){
      foreach($data as $id => $candidate){
 			  $html .= "<div class='candidate truncate'>";
 				  $html .= "<label>";
            $html .= "<input type='checkbox' name='candidates[]' value='$id' />";
            $html .= "<span title='{$candidate["name"]}'>{$candidate["name"]}</span>";
          $html .= "</label>";
   			$html .= "</div>";
 		  }
      return $html;
    }else{
      return "No Candidates Found";
    }
 	}
  
  /**
   * @param string $gender Acts as both gender and class
   * @param string $div Class Division
   */
  public function getCandidates($gender = null, $div = null){
    if($gender === null)
      return $this->candidates;
    
    if($this->config["type"] === "class" && $gender !== null && $div !== null){
      $candidates = array();
      
      foreach($this->candidates as $id => $candidate){
        if($candidate["class"] === $gender && $candidate["division"] === $div){
          $candidates[$id] = $candidate;
        }
      }
      return $candidates;
    }
    
    if($this->isElection() && empty($this->maleCandidates) && empty($this->femaleCandidates)){
      foreach($this->candidates as $id => $candidate){
        if($candidate["gender"] === "m")
          $this->maleCandidates[$id] = $candidate;
        else
          $this->femaleCandidates[$id] = $candidate;
      }
    }
    
    return $gender === "male" ? $this->maleCandidates : $this->femaleCandidates;
  }
  
  public function getCandidateName($id){
    return $this->candidates[$id]["name"];
  }
 	
 	/**
   * Check if the student has already voted
   */
 	public function didVote($id){
 		$id = strtoupper($id);
		return $this->app->getData("voted-$id") !== null;
 	}

 	
 	/**
   * Do a Vote
   * @param string $voterID The voter's ID
   * @param array $votedCands The ID of candidates voter chose
   */
 	public function vote($voterID, $votedCands){
    $cands = $this->app->getJSONData("candidates");
    
    /**
     * Increment votes of candidates
     */
    foreach($votedCands as $candID){
      $cands[$candID]["votes"]++;
    }
    
    $this->app->saveJSONData("candidates", $cands);
  
    $voterID = strtoupper($voterID); // I have no idea why I chose upper case characters
    $this->app->saveData("voted-$voterID", 1);
 	}
 	
 	/**
   * See if election has started
   * If there are candidates, then election has started
   */
 	public function isElection($type = ""){
 		return !empty($this->candidates);
 	}
 	
 	/**
   * Clear Data
   */
 	public function clear(){
    $App = new \Lobby\Apps("school-election");
    $App->clearData();
 	}
}
?>
