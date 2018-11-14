<?php
/*
database.php
A simple PDO wrapper for our database connection.

Created: 10/31/2018
Author: eCommerce
*/

class Database extends PDO {
	public $db_type = 'mysql'; 
	
	public function __construct() {
		$db_host = "10.23.0.2";
		$db_name = "csc230ecommerce"; // same as your username
		$db_username = "csc230ecommerce"; // your username
		$db_password = "C2dQbWn4Rw26Y29d"; // your password that I sent to you
		
		try {
			parent::__construct($this->db_type.":host=".$db_host.";dbname=".$db_name, $db_username, $db_password);
			parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			die("There was a problem connecting. " . $e->getMessage());
		}
	}
}

/*
--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(30) CHARACTER SET utf8 NOT NULL,
  `LastName` varchar(30) CHARACTER SET utf8 NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(13) NOT NULL,
  `Photo` varchar(255) NOT NULL,
  `PhotoBase64` mediumtext NOT NULL,
  `Access` varchar(10) NOT NULL,
  `LastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
