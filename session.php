<?php
/*
session.php
This is used for user login and handling messages to the user.
There is also a function to errorOut if the program needs to stop everything and give the user a message.

Created: 10/31/2018
Author: Larry Elliott
*/

require_once "classes/user.php";
require_once "classes/form.php";
require_once "classes/page.php";

class Session {
	private $db;
	
	public function __construct($db) {
		session_start();
		$this->db = $db;
		
		if (isset($_GET['logout']))
			$this->logOut();
		
		if (!isset($_SESSION['cscMessages']))
			$_SESSION['cscMessages'] = array();
	}
	
	public function loggedIn () {
		if (isset($_POST['Username'])) {
			$user = new User($this->db, $this, $_POST['Username'], $_POST['Password']);
			$_SESSION['cscUserID'] = $user->getID();

			$UserID = $user->getID();

			$stmt = $this->db->prepare('SELECT * FROM orders WHERE UserID=:UserID AND status= "cart"');
			$stmt->bindParam(':UserID', $UserID);
			$stmt->execute();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
			{
				
			}
			else
			{
				$stmt = $this->db->prepare('INSERT INTO orders (UserID, status) VALUES (:UserID, "cart")');
				$stmt->bindParam(':UserID', $UserID);
				$stmt->execute();
			}
			$stmt = $this->db->prepare('SELECT OrderID FROM orders WHERE UserID=:UserID AND status= "cart"');
			$stmt->bindParam(':UserID', $UserID);
			$stmt->execute();

			$results = $stmt->fetch(PDO::FETCH_ASSOC);

			$_SESSION['OrderID'] = $results['OrderID'];
			return $_SESSION['cscUserID'];
		}
		
		if (!isset($_SESSION['cscUserID']))
			return false;
		return $_SESSION['cscUserID'];
	}
	
	public function logOut () {
		$_SESSION['cscUserID'] = "";
		unset($_SESSION['cscUserID']);
		session_destroy();
	}
	
	public function addMessage ($status, $message) {
		// $status should be success, danger, warning, info (primary, secondary, light, and dark will also work)
		// see https://getbootstrap.com/docs/4.0/components/alerts/
		$_SESSION['cscMessages'][] = array($status,$message);
	}
	
	public function errorOut () {
		$page = new Page("Sorry. There was an Error");
		$page->containerStart("messages");
		$page->addContent($this->getMessages());
		$page->containerEnd();
		$page->renderPage();
		exit();
	}
	
	public function getMessages () {
		$messages = "";
		foreach ($_SESSION['cscMessages'] as $message) {
			$messages .= '<div class="alert alert-'.$message[0].'" role="alert">'.$message[1].'</div>';
		}
		$_SESSION['cscMessages'] = array();
		return $messages;
	}
	
	public function loginForm () {
		$form = new Form("login-form");
		$form->addTextInput('Username', true, "Email");
		$form->addPassword('Password');
		$form->addSubmit('Login');
		return $form->getForm();
	}
}