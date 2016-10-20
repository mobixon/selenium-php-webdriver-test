<?php 
ini_set(max_execution_time, 500);

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

require_once('tests/github/LoginPage.php');
require_once('tests/github/MainPage.php');
require_once('tests/github/NewRepoPage.php');

$host = 'http://localhost:4444/wd/hub';

$gh_login = "yourmail@gmail.com";
$gh_pass = "pass";
$new_repo_name = "test2";
$new_repo_descr = "test";

$capabilities = DesiredCapabilities::firefox();
$driver = RemoteWebDriver::create($host, $capabilities, 5000);
$login = new login_page();
$mainpage = new main_page();
$newrepopage = new new_repo_page();

echo "Test1 -----------------(Github login)<br>";
$driver = $login->loginAs($driver,$gh_login,$gh_pass);
if(!$login->checkLogin($driver)){
	echo "Login failure!<br>";
	$driver->quit();
	exit();
}
echo "Login success!<br><br>";

echo "Test2 -----------------(Github logout)<br>";

$mainpage->load($driver);
$driver = $mainpage->logout_click();
if($login->checkLogin($driver)){
	echo "Logout failure!<br>";
	$driver->quit();
	exit();
}
echo "Logout success!<br><br>";

echo "Test3 -----------------(Github create repo)<br>";
$driver = $login->loginAs($driver,$gh_login,$gh_pass);
if(!$login->checkLogin($driver)){
	echo "Login failure!<br>";
	$driver->quit();
	exit();
}
$mainpage->load($driver);
$driver = $mainpage->newRepo_click();
echo "Start creating new repo.<br>";
$driver = $newrepopage->createRepo($driver,$new_repo_name,$new_repo_descr);
if(!$driver){
	if($newrepopage->checkRepoCreation($driver,$new_repo_name)){
		echo "Repo '".$new_repo_name."' alredy exist!<br><br>";
	}else{
		echo "Creating repo '".$new_repo_name."' failure!<br><br>";
	}
}else{
	if($newrepopage->checkRepoCreation($driver,$new_repo_name)){
		echo "New repo '".$new_repo_name."' created!<br><br>";
	}
}


if($driver)
$driver->quit();
