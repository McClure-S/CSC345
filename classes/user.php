<?php
/*
user.php
This User Class handles everything pertaining to users.

Created: 10/31/2018
Author: eCommerce
*/
require_once "classes/database.php";
require_once "classes/form.php";

class User {
	private $db;
	private $OriginalID;
	private $ID;
	private $FirstName;
	private $LastName;
	private $Email;
	private $Password;
	private $Photo;
	private $PhotoBase64;
	private $Access;
	private $Cart;
	
	public function __construct($db, $session, $IDorEmail = false, $Password = false) {
		
		$this->db = $db;
		
		if ($IDorEmail !== false && $Password !== false) {
			$this->Password = $this->encryptPassword($Password);
			$stmt = $this->db->prepare('SELECT * FROM user WHERE Email=:Username AND Password=:Password');
			$stmt->bindParam(':Username', $IDorEmail);
			$stmt->bindParam(':Password', $this->Password);

		
			$stmt->execute();

			if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$this->OriginalID = $row['ID'];
				$this->ID = $row['ID'];

				$this->FirstName = $row['FirstName'];
				$this->LastName = $row['LastName'];
				$this->Email = $row['Email'];
				$this->Photo = $row['Photo'];
				$this->PhotoBase64 = $row['PhotoBase64'];
				$this->Access = $row['Access'];
				$this->Cart = $row['Cart'];
			} else {
				$session->addMessage("danger","Error getting User. Invalid Username or Password.");
				$session->errorOut();
			}
		} 

		else if ($IDorEmail !== false && $IDorEmail != "new") {
			$stmt = $this->db->prepare('SELECT * FROM user WHERE ID=:ID');
			$stmt->bindParam(':ID', $IDorEmail);
			$stmt->execute();
			if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$this->OriginalID = $row['ID'];
				$this->ID = $row['ID'];
				$this->FirstName = $row['FirstName'];
				$this->LastName = $row['LastName'];
				$this->Email = $row['Email'];
				$this->Password = $row['Password'];
				$this->Photo = $row['Photo'];
				$this->PhotoBase64 = $row['PhotoBase64'];
				$this->Access = $row['Access'];
			} else {
				$session->addMessage("danger","Error getting User.");
				$session->errorOut();
			}
		} else {
			$this->OriginalID = "new";
			$this->ID = "new";
			$this->FirstName = "";
			$this->LastName = "";
			$this->Email = "";
			$this->Password = "";
			$this->Photo = "";
			$this->PhotoBase64 = "";
			$this->Access = "";
		}
	}
	
	public function getID () {
		return $this->ID;
	}

	
	public function getFirstName () {
		return $this->FirstName;
	}

	
	public function getLastName () {
		return $this->LastName;
	}

	
	public function getEmail () {
		return $this->Email;
	}

	
	public function getPassword () {
		return $this->Password;
	}

	
	public function getPhoto () {
		return $this->Photo;
	}

	
	public function getPhotoBase64 () {
		return $this->PhotoBase64;
	}

	
	public function getAccess () {
		return $this->Access;
	}

	public function getCart(){
		return $this->Cart;
	}

	public function setCart(){
		$this->Cart= $value;
	}
	
	public function setFirstName ($value) {
		$this->FirstName = $value;
	}

	
	public function setLastName ($value) {
		$this->LastName = $value;
	}

	
	public function setEmail ($value) {
		$this->Email = $value;
	}

	
	public function setPassword ($value) {
		$this->Password = encryptPassword($value);
	}

	
	public function setPhoto ($value) {
		$this->Photo = $value;
	}

	
	public function setPhotoBase64 ($value) {
		$this->PhotoBase64 = $value;
	}

	
	public function setAccess ($value) {
		$this->Access = $value;
	}
	
	private function encryptPassword ($password) {
		$salt = "sdkjhrDDIT472ns72SJh364";
		return crypt($password, $salt);
	}
	
	private function save() {
		if ($this->OriginalID == "new") {
			$stmt = $this->db->prepare(
				'INSERT INTO user (FirstName, LastName, Email, Password, Photo, PhotoBase64, Access) 
				VALUES (:FirstName, :LastName, :Email, :Password, :Photo, :PhotoBase64, :Access)');
			$stmt->bindParam(':FirstName', $this->FirstName);
			$stmt->bindParam(':LastName', $this->LastName);
			$stmt->bindParam(':Email', $this->Email);
			$stmt->bindParam(':Password', $this->Password);
			$stmt->bindParam(':Photo', $this->Photo);
			$stmt->bindParam(':PhotoBase64', $this->PhotoBase64);
			$stmt->bindParam(':Access', $this->Access);
			$stmt->execute();
		} else {
			$stmt = $this->db->prepare(
				'UPDATE user SET FirstName=:FirstName, LastName=:LastName, Email=:Email, 
					Password=:Password, Photo=:Photo, PhotoBase64=:PhotoBase64, Access=:Access, ID=:ID
				WHERE ID=:OriginalID');
			$stmt->bindParam(':FirstName', $this->FirstName);
			$stmt->bindParam(':LastName', $this->LastName);
			$stmt->bindParam(':Email', $this->Email);
			$stmt->bindParam(':Password', $this->Password);
			$stmt->bindParam(':Photo', $this->Photo);
			$stmt->bindParam(':PhotoBase64', $this->PhotoBase64);
			$stmt->bindParam(':Access', $this->Access);
			$stmt->bindParam(':ID', $this->ID);
			$stmt->bindParam(':OriginalID', $this->OriginalID);
			$stmt->execute();
		}
	}
	
	public function editForm () {
		$_POST['OriginalID'] = $this->OriginalID;
		$_POST['ID'] = $this->ID;
		$_POST['FirstName'] = $this->FirstName;
		$_POST['LastName'] = $this->LastName;
		$_POST['Email'] = $this->Email;
		//$_POST['Password'] = $this->Password;
		$_POST['Photo'] = $this->Photo;
		$_POST['Access'] = $this->Access;

		$form = new Form("user-form");
		$form->addHiddenField('OriginalID');
		$form->addDisabledField('ID');
		$form->addTextInput('FirstName');
		$form->addTextInput('LastName');
		$form->addTextInput('Email');
		$form->addPassword('Password', false);
		$form->addFileInput('Photo', false);
		$form->addSelect('Access',array("None","Admin"));
		$form->addSubmit('Save');
		return $form->getForm();
	}
	
	public static function saveForm($db, $session) {
		$user = new User($db, $session, $_POST['OriginalID']);
		//$session->addMessage("info",var_export($user,true));
		$user->ID = $_POST['ID'];
		$user->FirstName = $_POST['FirstName'];
		$user->LastName = $_POST['LastName'];
		$user->Email = $_POST['Email'];
		if ($_POST['Password'] != "")
			$user->Password = $user->encryptPassword($_POST['Password']);
		$user->Photo = $_POST['Photo'];
		$user->PhotoBase64 = $_POST['PhotoBase64'];
		$user->Access = $_POST['Access'];
		//$session->addMessage("info",var_export($user,true));
		$user->save();
		$session->addMessage("success","The user was saved.");
	}
	
	public static function allUsersTable ($db, $admin_view = false) {
		$stmt = $db->query('SELECT * FROM user');
		
		$table  = "<table class=\"datatable\" border=\"1\">\n";
		$table .= "<thead>\n";
		$table .= "<tr><th>ID</th><th>FirstName</th><th>LastName</th><th>Email</th><th>Access</th></tr>\n";
		$table .= "</thead>\n";
		$table .= "<tbody>\n";

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$table .= "<tr>\n";
			if ($admin_view)
				$table .= "\t<td><a href=\"?edit=".$row['ID']."\">".$row['ID']."</a></td>\n";
			else
				$table .= "\t<td>".$row['ID']."</td>\n";
			$table .= "\t<td>".$row['FirstName']."</td>\n";
			$table .= "\t<td>".$row['LastName']."</td>\n";
			$table .= "\t<td>".$row['Email']."</td>\n";
			$table .= "\t<td>".$row['Access']."</td>\n";
			$table .= "</tr>\n";
		}

		$table .= "</tbody>\n";
		$table .= "</table>\n";
		if ($admin_view)
			$table .= '<a href="?edit=new" class="btn btn-primary active" role="button" aria-pressed="true">New User</a>';
		return $table;
	}
	
	public static function allUsersCards ($db) {
	    //https://www.w3schools.com/howto/howto_css_product_card.asp
		$stmt = $db->query('SELECT * FROM user');
		
		$cards  = '<div class="row center-block">';//'<div class="w3-row">';

		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			
			$image = 'https://www.w3schools.com/howto/img_avatar.png';
			if (strlen($row['PhotoBase64']) > 1)
				$image = $row['PhotoBase64'];
			
			$cards .= '
			<div class="card col-sm-6">
				<img src="'.$image.'" alt="Avatar" style="width:100%">
				<h1>'.$row['FirstName'].' '.$row['LastName'].'</h1>
				<p class="price">$19.99</p>
				<p>My ID number is '.$row['ID'].'</p>
				<a href="?profile='.$row['ID'].'" class="btn btn-primary">See Profile</a>
			</div>
			';
		}
		
		$cards .= "</div>\n";
		
		return $cards;
	}


	public static function cartCard ($db, $session) {
		
		//I just need to figure out how to get the ID of the current user.
		$userID = $session->loggedIn();
		
		
		//finds person in db using ID
		$stmt = $db->query('SELECT Cart FROM user WHERE id="'.$userID.'"');
		
		//now this gets their cart value
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$cartItems = $row["Cart"];
		

		$cards  = '<div class="row center-block">';

		if(strlen($cartItems) !== 0){
			for($i = 0; $i < strlen($cartItems); $i++){

				$stmt = $db->query('SELECT * FROM inventory WHERE id="'.$cartItems[$i].'"');




				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					
					$image = $row["image ref"];
					//$cost = $row["cost"];

					$cards .= '
					<div class="card col-sm-6">
						
						<img src="'.$image.'" alt="Avatar" style="width:100%">
						<h1>'.$row['name'].'</h1>
						<p class="price">$'.$row['cost'].'</p>
						<h3>Description: </h3>
						<p style="text-align: left; padding-left: 10px; padding-right: 10px;">'.$row['description'].'</p>
					
						<a href="?removeItem='.$row['id'].'" class="btn btn-primary">Remove from cart</a>
						</div>
					';
				}
			}
		}

		else{
			$session->addMessage("danger","Your cart is empty.");
		}


		$cards .= "</div>\n";
		
		return $cards;
	}

	public static function allItemCards ($db) {
	    //https://www.w3schools.com/howto/howto_css_product_card.asp
	    $stmt = $db->query('SELECT * FROM inventory');
	    
	    $cards  = '<div class="row center-block">';//'<div class="w3-row">';
	    
	    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	        
	        $image = 'https://www.w3schools.com/howto/img_avatar.png';
	        if (strlen($row['image ref']) > 1)
	            $image = $row['image ref'];
	            
	            $cards .= '
			<div class="card col-sm-6">
				<img src="'.$image.'" alt="Avatar" style="width:100%">
				<h1>'.$row['name'].' '.$row['type'].'</h1>
				<p class="price">$'.$row['cost'].'</p>
				<p>My ID number is '.$row['id'].'</p>
				<a href="?profile='.$row['id'].'" class="btn btn-primary">See Profile</a>
			</div>
			';
	    }
	    
	    $cards .= "</div>\n";
	    
	    return $cards;
	}

	public static funtion removeItem($ID, $db){
		
	}

}
