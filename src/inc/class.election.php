<?php
namespace Lobby\App\school_election;

class Election {

  private $maleCandidates = array();
  private $femaleCandidates = array();
 	
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
 			  $html .= "<div class='candidate'>";
 				  $html .= "<label>";
            $html .= "<input type='checkbox' name='candidates[]' value='$id' />";
            $html .= "<span>{$candidate["name"]}</span>";
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
 		
    $votes = $this->app->getJSONData("election_votes");
    if(!is_array($votes)){
      $votes = array();
    }
      
		return isset($votes[$id]) === false ? false : true;
 	}

 	
 	/**
   * This is the updatal of candidate vote
   */
 	public function vote($voterID, $candidates){
 		if($voterID != ""){
 			$voterID = strtoupper($voterID); // I have no idea why I chose upper case characters
      $votes = $this->app->getJSONData("election_votes");
      
      if(!is_array($votes)){
        $votes = array();
      }
      $votes[$voterID] = $candidates;
      $this->app->saveJSONData("election_votes", $votes);
 		}
 	}
 	
 	/**
   * See if election has started
   * If there are candidates, then election has started
   */
 	public function isElection($type = ""){
 		return !empty($this->candidates);
 	}
 	
 	/**
   * Make changes to the live election page
   */
 	public function liveChange($type = ""){
 		$codes = array(
 			"reload" => "window.location = window.location;",
 			"reset"  => "1"
 		);
 		if( isset($codes[$type]) ){
 			$this->app->saveData("election_ajax_script", $codes[$type]);
 		}else{
 			return false;
 		}
 	}
  
  /**
   * Get Votes
   */
  public function count($candidates){
    $votes = $this->app->getJSONData("election_votes");
    $votes = is_array($votes) ? $votes : array();
    
    $results = array_fill_keys(array_column($candidates, "name"), 0);
    
    foreach($votes as $canID => $vote){
      foreach($vote as $canID){
        if(isset($candidates[$canID])){
          $results[$candidates[$canID]["name"]] = $results[$candidates[$canID]["name"]] + 1;
        }
      }
    }
    return $results;
  }
 	
 	/**
   * Clear Data
   */
 	public function clear(){
    $this->app->removeData("candidates");
    $this->app->removeData("student_passwords");
    $this->app->removeData("election_votes");
 	}
}
?>
