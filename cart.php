<?php

require_once "classes/session.php";
require_once "classes/page.php";
require_once "classes/database.php";
require_once "classes/user.php";
require_once "classes/form.php";
require_once "classes/checkout.php";

$db = new Database();
$session = new Session($db);
$checkout = new Checkout($db);

$loggedInID = $session->loggedIn();

$page = new Page("Maple Blaze");
$page->setSubtitle("Weed Ey?");

//	Commented out until login thing is fixed... // 

if ($loggedInID) 
{
	$page->addNavigationItem("Home", './');
	$page->addNavigationItem("Manage Users", 'user.php');
	$page->addNavigationItem("Cart",'cart.php');
	$page->addNavigationItem("Log Out", "?logout");
} else 
{
	$page->addNavigationItem("Log In", '#" data-toggle="modal" data-target="#loginModal');
	//https://www.w3schools.com/bootstrap/bootstrap_modal.asp
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
	
	$session->addMessage('warning', 'You have to log in before you can use this page.');
	$page->containerStart("edit2");
	$page->addContent($session->loginForm());
	$page->containerEnd();
	$page->renderPage($session);
	exit;
}

$user = new User($db, $session, $loggedInID);



if (isset($_POST['OriginalID']))
{
	User::saveForm($db,$session);
}

if (isset($_POST['Address']))
{
	Checkout::saveCheckout($db,$session);
	Checkout::cartRefresh($db,$session,$user);
}
	$page->addContent('<div id="cardbg">');
	$page->containerStart("edit-form");
	$user = new User($db, $session, "fowler1na@alma.edu", "letmein");
	$page->addContent($user->cartCard($db, $session));
	$page->addContent($checkout->checkoutForm());
	$page->containerEnd();
	$page->addContent('</div>');
 
//  else {
// 	$page->containerStart("user-table");
// 	$page->addContent(User::allUsersTable($db, true));
// 	$page->containerEnd();
// }


$page->renderPage($session);







