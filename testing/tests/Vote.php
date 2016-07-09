<?php
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class Vote extends PHPUnit_Framework_TestCase {

  public function setUp(){
    /**
     * Configure Selenium server
     */
    $this->driver = RemoteWebDriver::create("http://localhost:4444/wd/hub", DesiredCapabilities::firefox());
  }
  
  public function testLogin(){
    $this->driver->get("http://". LOBBY_URL . "/admin");
    
    /**
     * Step 2
     */
    // Choose MySQL
    $this->driver->findElement(WebDriverBy::cssSelector("a.green"))->click();
    
    $this->driver->findElement(WebDriverBy::cssSelector("input[name=dbhost]"))->clear()->sendKeys("localhost");
  }

}
