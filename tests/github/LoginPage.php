<?php

class login_page {
    private $usernameLocator = 'login_field';
    private $passwordLocator = 'password';

    private $driver;

    private function load() {
       	$this->driver->get('https://github.com/login');
    }

    public function checkLogin($driver) {
        if($driver->manage()->getCookieNamed('logged_in')['value']=="yes") 
            return true;
        else
            return false;
    }

    private function typeUsername($username) {
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::id($this->usernameLocator))->sendKeys($username);
    }

    private function typePassword($password) {
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::id($this->passwordLocator))->sendKeys($password);  
    }

    private function submit() {
        $this->driver->findElement(Facebook\WebDriver\WebDriverBy::id($this->passwordLocator))->submit();
        return true; 
    }

    public function loginAs($driver, $username, $password) {
        $this->driver = $driver;
        if($this->checkLogin($this->driver)){
            return $this->driver;
        }else{
            $this->load();
            $this->typeUsername($username);
            $this->typePassword($password);
            $this->submit();
            return $this->driver;
        }        
    }

}