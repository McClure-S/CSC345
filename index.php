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

$page = new Page("Software Engineering");
$page->setSubtitle("Group 1");


if ($loggedInID) {
	$page->addNavigationItem("Manage Users", 'user.php');
	$page->addNavigationItem("Log Out", "?logout");
} else {
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
}

$page->containerStart("user-cards");
$page->addContent(User::allUsersCards($db));
$page->containerEnd();

$page->containerStart("user-table","bg-light");
$page->addContent(User::allUsersTable($db));
$page->containerEnd();

$page->containerStart("edit1");
$user = new User($db, $session, "elliott@alma.edu", "myPassword");
$page->addContent($user->editForm());
$page->containerEnd();

$page->containerStart("edit2","bg-light");
$user = new User($db, $session);
$page->addContent($user->editForm());
$page->containerEnd();

$page->containerStart("edit3");
$user = new User($db, $session, 3);
$page->addContent($user->editForm());
$page->containerEnd();




$page->renderPage($session);
