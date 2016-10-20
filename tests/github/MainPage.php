<?php

class main_page {
    private $driver;

    public function load($driver) {
        $this->driver = $driver;
        $this->driver->get('https://github.com');
    }


    public function newRepo_click() {
         $this->driver->findElement(Facebook\WebDriver\WebDriverBy::cssSelector('a.header-nav-link[href="/new"]'))->click();
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::cssSelector('a.dropdown-item[href="/new"]'))->click();
        return $this->driver;
    }

    public function logout_click() {
        
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::cssSelector('a[href="/'.$this->driver->manage()->getCookieNamed('dotcom_user')['value'].'"]'))->click();
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::className('dropdown-signout'))->click();
        return $this->driver;
    }

    public function checkLogout() {
        if(!isset($this->driver->manage()->getCookieNamed('logged_in')['value']) || $this->driver->manage()->getCookieNamed('logged_in')['value']!="yes" ){
            return $this->driver;
        }
        $this->driver->quit();
        return fasle;
    }


}