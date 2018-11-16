<?php
/*
checkout.php
Handles the checkout methonds and forms.

Created: 11/08/2018
Author: Spencer McClure
*/

require_once "classes/database.php";
require_once "classes/form.php";

class Checkout{
	private $db;
	private $form;

	public function __construct($db){
		$this->db = $db;
	}

	public function checkoutForm () {
		$form = new Form("checkout-form");
		$form->addTextInput('Address', true);
		$form->addSubmit('Checkout');
		return $form->getForm();
	}

	public static function saveCheckout($db, $session) {
		

		$address = $_POST['Address'];
		$status = "submitted";



		$stmt = $db->prepare('UPDATE orders SET status =:Status, Address =:Address WHERE OrderID=:OrderID');
		$stmt->bindParam(':Address', $address);
		$stmt->bindParam(':Status', $status);
		$stmt->bindParam(':OrderID', $_SESSION['OrderID']);
		$stmt->execute();

		$session->addMessage("success","Your order has been submitted, thank you for your patronage.");

		
	}

	public static function cartRefresh($db, $session, $user)
	{
		$UserID = $user->getID();
		$stmt = $db->prepare('INSERT INTO orders (UserID, status) VALUES (:UserID, "cart")');
		$stmt->bindParam(':UserID', $UserID);
		$stmt->execute();

		$stmt = $db->prepare('SELECT OrderID FROM orders WHERE UserID=:UserID AND status= "cart"');
		$stmt->bindParam(':UserID', $UserID);
		$stmt->execute();

		$results = $stmt->fetch(PDO::FETCH_ASSOC);
		$_SESSION['OrderID'] = $results['OrderID'];
		return $_SESSION['cscUserID'];
	}
}