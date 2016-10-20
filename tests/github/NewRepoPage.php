<?php

class new_repo_page {
    private $driver;

    private function typeRepoName($name) {
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::id('repository_name'))->sendKeys($name);
    }

    private function typeDescr($descr) {
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::id('repository_description'))->sendKeys($descr);  
    }

    private function submit() {
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::cssSelector('.new-repo-container button[type="submit"]'))->submit();
        return true; 
    }

    public function createRepo($driver, $name="test",$descr="test") {
        $this->driver = $driver;
        $this->typeRepoName($name);
        $this->typeDescr($descr);
        $this->submit();
        if($this->driver->getCurrentURL()=="https://github.com/repositories") return false;
        return $this->driver;
    }

    public function checkRepoCreation($driver, $name) {
        $this->driver->get('https://github.com/'.$this->driver->manage()->getCookieNamed('dotcom_user')['value'].'/'.$name);
        if(stripos($this->driver->getTitle(),"Page not found")!==false)
            return fasle;
        else
            return true;
    }


}