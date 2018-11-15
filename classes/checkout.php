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
		$form->addTextInput('Name', true);
		$form->addTextInput('Date of Birth', true);
		$form->addTextInput('Address', true);
		$form->addSubmit('Checkout');
		return $form->getForm();
	}
}