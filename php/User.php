<?php

//We use this class as an abstraction for our 'user' objects where we can invoke live updates 
//within the persistent correspondent by simply setting instance variables on user objects returned by
// 'current_user()' within helper_functions.php

require_once 'connect.php';
require_once 'functions.php';

class User {
	var $firstName;
	var $lastName;
	var $email;

	function __construct($firstName, $lastName, $email) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
	}

	function getFirstName() {
		echo $this->firstName;
	}

	function setFirstName($firstName) {
		$this->firstName = strip($firstName);
		$result = pg_query("
			UPDATE users 
			SET first_name = '{$this->firstName}'
			WHERE email = '{$this->email}';");
	}

	function getLastName() {
		echo $this->lastName;
	}

	function setLastName($lastName) {
		$this->lastName = $lastName;
		$result = pg_query("
			UPDATE users 
			SET last_name = '{$this->lastName}'
			WHERE email = '{$this->email}';");
	}

	function getEmail() {
		echo $this->email;
	}

	function setEmail($email) {
		$oldEmail = $this->email;
		$this->email = $email;
		$result = pg_query("
			UPDATE users 
			SET email = '{$this->email}'
			WHERE email = '{$oldEmail}';");
	}

	function changeEncryptedPassword($password) {
		$securePassword = md5(strip($password));
		$result = pg_query("
			UPDATE users 
			SET encrypted_password = '{$securePassword}'
			WHERE email = '{$this->email}';");

	}
}
?>