<?php
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class Vote extends PHPUnit_Framework_TestCase {

  private $defaultConfig;
  private $neededResult = array();

  public function setUp(){
    /**
     * Configure Selenium server
     */
    $this->driver = RemoteWebDriver::create("http://localhost:4444/wd/hub", DesiredCapabilities::firefox());
    $this->configPath = __DIR__ . "/../../src/data/default-config.json";
    $this->originalConfigFile = file_get_contents($this->configPath);
    $this->defaultConfig = json_decode($this->originalConfigFile, true);
  }
  
  private function togglePasswordFeature(){
    $newConfig = $this->defaultConfig;
    $newConfig["password"] = $newConfig["password"] === "1" ? "0" : "1";
    file_put_contents($this->configPath, json_encode($newConfig));
  }
  
  public function testPasswordToggle(){
    $this->driver->get(LOBBY_URL . "/app/school-election");
    $this->assertNotContains("Password", $this->driver->getPageSource());
    
    $this->togglePasswordFeature();
    
    $this->driver->get(LOBBY_URL . "/app/school-election");
    $this->assertContains("Password", $this->driver->getPageSource());
  }
  
  public function testVoting(){
    for($i=1;$i < 10;$i++){
      $this->driver->get(LOBBY_URL . "/app/school-election");
      
      $select = new WebDriverSelect($this->driver->findElement(WebDriverBy::cssSelector("#voterForm [name=class]")));
      $select->selectByValue("6");
      
      $select = new WebDriverSelect($this->driver->findElement(WebDriverBy::cssSelector("#voterForm [name=division]")));
      $select->selectByValue("C");
      
      $this->driver->findElement(WebDriverBy::cssSelector("#voterForm [name=roll]"))->sendKeys($i);
      $this->driver->findElement(WebDriverBy::cssSelector("#voterForm"))->submit();
      
      $wait = new WebDriverWait($this->driver, 5);
      $driver = $this->driver;
      $wait->until(function() use($driver){
        return count($driver->findElements(WebDriverBy::cssSelector("#voteForm .candidate"))) > 2;
      });
      
      $candidates = $this->driver->findElements(WebDriverBy::cssSelector("#voteForm .candidate"));
      shuffle($candidates);
      
      $candidateName = $this->driver->executeScript("arguments[1].checked = true;return arguments[0].innerText;", array(
        $candidates[0]->findElement(WebDriverBy::cssSelector("span")),
        $candidates[0]->findElement(WebDriverBy::cssSelector("input"))
      ));
      $this->neededResult[$candidateName] = isset($this->neededResult[$candidateName]) ? $this->neededResult[$candidateName] + 1 : 1;
      
      $this->driver->findElement(WebDriverBy::cssSelector("#voteForm"))->submit();
    }
    
    $this->driver->get(LOBBY_URL . "/app/school-election/admin/stats");
    $page = $this->driver->getPageSource();
    foreach($this->neededResult as $candidate => $votes){
      $this->assertContains("$candidate - $votes", $page);
    }
  }
  
  /**
   * Boys & Girls and Choose 4 candidates
   */
  public function testMultipleVoting(){
    $newConfig = $this->defaultConfig;
    $newConfig["password"] = "0";
    $newConfig["type"] = "multiple";
    $newConfig["able-to-choose"] = "2";
    file_put_contents($this->configPath, json_encode($newConfig));
    
    for($i=1;$i < 10;$i++){
      $this->driver->get(LOBBY_URL . "/app/school-election");
      
      $select = new WebDriverSelect($this->driver->findElement(WebDriverBy::cssSelector("#voterForm [name=class]")));
      $select->selectByValue("9");
      
      $select = new WebDriverSelect($this->driver->findElement(WebDriverBy::cssSelector("#voterForm [name=division]")));
      $select->selectByValue("B");
      
      $this->driver->findElement(WebDriverBy::cssSelector("#voterForm [name=roll]"))->sendKeys($i);
      $this->driver->findElement(WebDriverBy::cssSelector("#voterForm"))->submit();
      
      /**
       * Error alert box when only 1 candidate or nothing is selected
       */
      $this->driver->executeScript("arguments[0].checked = true;", array(
        $this->driver->findElements(WebDriverBy::cssSelector("#voteForm #girls .candidate"))
      ));
      $this->driver->findElement(WebDriverBy::cssSelector("#voteForm"))->submit();
      $this->assertContains("Please Select 2 Girl(s)", $this->driver->getPageSource());
      
      $boysAndGirlsCandidates = array(
        $this->driver->findElements(WebDriverBy::cssSelector("#voteForm #boys .candidate")),
        $this->driver->findElements(WebDriverBy::cssSelector("#voteForm #girls .candidate"))
      );
      foreach($boysAndGirlsCandidates as $candidates){
        shuffle($candidates);
        
        /**
         * Vote 4 candidates
         */
        for($j=0;$j < 2;$j++){
          $candidateName = $this->driver->executeScript("arguments[1].checked = true;return arguments[0].innerText;", array(
            $candidates[$j]->findElement(WebDriverBy::cssSelector("span")),
            $candidates[$j]->findElement(WebDriverBy::cssSelector("input"))
          ));
          $this->neededResult[$candidateName] = isset($this->neededResult[$candidateName]) ? $this->neededResult[$candidateName] + 1 : 1;
        }
      }
      
      $this->driver->findElement(WebDriverBy::cssSelector("#voteForm"))->submit();
    }
    
    $this->driver->get(LOBBY_URL . "/app/school-election/admin/stats");
    $page = $this->driver->getPageSource();
    foreach($this->neededResult as $candidate => $votes){
      $this->assertContains("$candidate - $votes", $page);
    }
  }
  
  public function testClearData(){
    /**
     * Clear Election Data
     */
    $this->driver->get(LOBBY_URL . "/app/school-election/admin");
    $this->driver->findElement(WebDriverBy::cssSelector("#workspace button[name=clearData]"))->click();
    $this->driver->switchTo()->alert()->accept();
    $this->assertContains("Successfully Cleared Data", $this->driver->getPageSource());
  }
  
  public function tearDown(){
    file_put_contents($this->configPath, $this->originalConfigFile);    
    $this->driver->close();
  }
  
}
