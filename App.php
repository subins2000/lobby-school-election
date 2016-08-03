<?php
namespace Lobby\App;

/**
 * School Election
 * - Subin Siby
 */
class school_election extends \Lobby\App {
  
  public $config = array();
  
  public function init(){
    $this->config = json_decode($this->fs->get("src/data/default-config.json"), true);
    $this->config = $this->config + $this->getJSONData("config");
    $this->config = array_replace($this->config, $this->getJSONData("config"));
    
    require_once $this->dir . "/src/inc/class.election.php";
    $this->EC = new \Lobby\App\school_election\Election($this);
  }
  
  public function page($p){
    return "auto";
  }

}
