<?php
/*
index.php
This is the landing page.

Created: 10/31/2018
Author: Larry Elliott
*/

require_once "classes/session.php";
require_once "classes/page.php";
require_once "classes/database.php";
require_once "classes/user.php";
require_once "classes/form.php";

$db = new Database();
$session = new Session($db);

$loggedInID = $session->loggedIn();

$page = new Page("Maple Blaze");
$page->setSubtitle("Weed Eh?");

//shows the navigation bar
if ($loggedInID) {
	$page->addNavigationItem("Manage Users", 'user.php');
	$page->addNavigationItem("Cart", "cart.php");
	$page->addNavigationItem("Log Out", "?logout");
} else {
	$page->addNavigationItem("Log In", '#" data-toggle="modal" data-target="#loginModal');
	$page->addNavigationItem("Sign Up", '#" data-toggle="modal" data-target="#signUpModal');

	//https://www.w3schools.com/bootstrap/bootstrap_modal.asp
	//displays the login/signup form when you click them
	$page->addContent('
	<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:10000">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalLabel">Sign In</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					'.$session->loginForm().'
				</div>
			</div>
		</div>
	</div>');

	$page->addContent('
	<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:10000">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="exampleModalLabel">Sign In</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					'.$session->signUpForm().'

				</div>
			</div>
		</div>
	</div>');
}

//displays the cards
$page->addContent('<div id="cardbg">');
$page->containerStart("user-cards");
$page->addContent(User::allItemCards($db));
$page->containerEnd();
$page->addContent('</div>');



$page->renderPage($session);
