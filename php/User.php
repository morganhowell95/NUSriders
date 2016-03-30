<?php

//We use this class as an abstraction for our 'user' objects where we can invoke live updates 
//within the persistent correspondent by simply setting instance variables on user objects returned by
// 'current_user()' within helper_functions.php

class User {
	var $firstName;
	var $lastName;
	var $email;

	function __construct($firstName, $lastName, $email) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
	}

	function getFirstName(){
		echo $this->firstName;
	}

	function setFirstName($firstName){
		$this->firstName = $firstName;
	}

	function getLastName(){
		echo $this->lastName;
	}

	function setLastName($lastName){
		$this->lastName = $lastName;
	}

	function getEmail(){
		echo $this->email;
	}

	function setEmail($email){
		$this->email = $email;
	}
}

?>