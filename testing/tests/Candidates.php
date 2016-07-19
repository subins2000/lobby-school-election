<?php
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\JavaScriptExecutor;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class Candidates extends PHPUnit_Framework_TestCase {

  public function setUp(){
    /**
     * Configure Selenium server
     */
    $this->driver = RemoteWebDriver::create("http://localhost:4444/wd/hub", DesiredCapabilities::firefox());
  }

  public function testAddCandidates(){
    $this->driver->get(LOBBY_URL . "/app/school-election/admin/candidates");
    $this->driver->executeScript("document.querySelector('#workspace form').action='". LOBBY_URL ."/app/school-election/admin/candidates';");
    
    $names = array("Mary", "Simrin", "Cindy", "Polu", "Aiswarya", "Johns", "Marissa", "Linus");
    for($i=0;$i < 8;$i++){
      $this->driver->findElements(WebDriverBy::cssSelector("#workspace input[type=text]"))[$i]->sendKeys($names[$i]);
      if($i % 2 === 0)
        (new WebDriverSelect($this->driver->findElements(WebDriverBy::cssSelector("#workspace select"))[$i]))->selectByValue("f");
      $this->driver->findElement(WebDriverBy::cssSelector("#workspace #add"))->click();
    }
    
    $this->driver->findElement(WebDriverBy::cssSelector("#workspace form"))->submit();
    
    $this->driver->get(LOBBY_URL . "/app/school-election");
    for($i=0;$i < 8;$i++){
      $this->assertContains($names[$i], $this->driver->getPageSource());
    }
  }
  
  public function tearDown(){
    $this->driver->close();
  }

}
