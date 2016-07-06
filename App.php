<?php
namespace Lobby\App;

/**
 * School Election
 * - Subin Siby
 */
class school_election extends \Lobby\App {
  
  public $config = array();
  
  public function page($p){
    $this->config = json_decode($this->get("src/data/default-config.json"), true);
    $this->config = $this->config + $this->getJSONData("config");
    
    require_once $this->dir . "/src/inc/class.election.php";
    $this->EC = new \Lobby\App\school_election\Election($this);
    
    return "auto";
  }

}
