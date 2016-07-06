<?php
namespace Lobby\App\school_election;

class Election {

  private $maleCandidates = array();
  private $femaleCandidates = array();
 	
 	public function __construct($app){
    $this->config = $app->config;
    $this->app = $app;
    
    $this->maleCandidates = $this->app->getJSONData("male-candidates");
    $this->femaleCandidates = $this->app->getJSONData("female-candidates");
    $this->candidates = $this->maleCandidates + $this->femaleCandidates;
    
    return true;
 	}
 	
 	public function showCandidates(){
    /**
     * Boys Section
     */
 		echo "<div class='boys'>";
 			echo "<h2>Boys</h2>";
 			$this->candidates($this->maleCandidates);
 		echo "</div>";
 		
 		/**
     * Girls Section
     */
 		echo "<div class='girls'>";
 			echo "<h2>Girls</h2>";
 			$this->candidates($this->femaleCandidates);
 		echo "</div>";
 	}
 	
 	public function candidates($data){
 		if(count($data) == $this->config['female-candidates']){
      foreach($data as $id => $candidate){
 			  echo "<div class='candidate'>";
 				  echo "<label>";
            echo "<input type='checkbox' name='candidates[]' value='$id' />";
            echo "<span>$candidate</span>";
          echo "</label>";
   			echo "</div>";
 		  }
    }else{
      echo "No Candidates Found";
    }
 	}
  
  public function getCandidates(){
    return $this->candidates;
  }
  
  public function getCandidateName($id){
    return $this->candidates[$id];
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
   * See if Election Is Already Started
   */
 	public function isElection($type = ""){
 		if($type == ""){
 			$maleCandidates = $this->app->getJSONData("male-candidates");
      $femaleCandidates = $this->app->getJSONData("female-candidates");
      $count = count($maleCandidates) + count($femaleCandidates);
 		}elseif($type == "male"){
      $maleCandidates = $this->app->getJSONData("male-candidates");
      $count = count($maleCandidates);
 		}elseif($type == "female"){
      $femaleCandidates = $this->app->getJSONData("female-candidates");
      $count = count($femaleCandidates);
 		}

 		if($type == ""){
 			return $count != $this->config['total-candidates'] ? false:true;
 		}else{
 			return $count != $this->config["{$type}_candidates"] ? false:true;
 		}
 	}
 	
 	/* Make changes to the live election page */
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
  public function count($candidateNames){
    $votes = $this->app->getJSONData("election_votes");
    $votes = is_array($votes) ? $votes : array();
    
    $candidates = array_flip($candidateNames);
    $candidates = array_fill_keys(array_keys($candidates), 0);
    
    foreach($votes as $canID => $vote){
      foreach($vote as $canID){
        if(isset($candidateNames[$canID])){
          $candidates[$candidateNames[$canID]] = $candidates[$candidateNames[$canID]] + 1;
        }
      }
    }
    return $candidates;
  }
 	
 	/**
   * Clear Data
   */
 	public function clear(){
 		$this->removeData("male-candidates");
    $this->removeData("female-candidates");
    $this->removeData("student_passwords");
    $this->removeData("election_votes");
 	}
}
?>
