<?php

//We use this class as an abstraction for our 'user' objects where we can invoke live updates
//within the persistent correspondent by simply setting instance variables on user objects returned by
// 'current_user()' within functions.php

include_once 'php/connect.php';
include_once 'php/functions.php';

class User {
	public static $user = NULL;
	var $firstName;
	var $lastName;
	var $email;
	var $id;
	var $admin;

	private function __construct($id, $firstName, $lastName, $email, $admin) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->id = $id;
		$this->admin = $admin;
	}

	//Factory method for generating user objects
	public static function getInstance($id, $firstName, $lastName, $email, $admin) {
		if(self::$user == NULL) {
			$current_user = new User($id, $firstName, $lastName, $email, $admin);
			self::$user = $current_user;
			return self::$user;
		} else {
			return self::$user;
		}
	}

	function isAdmin() {
		return $this->admin == "t";
	}

	function getUserId() {
		return $this->id;
	}

	function getFirstName() {
		return $this->firstName;
	}

	function setFirstName($firstName) {
		$this->firstName = strip($firstName);
		$result = pg_query("
			UPDATE users
			SET first_name = '{$this->firstName}'
			WHERE email = '{$this->email}';");
	}

	function getLastName() {
		return $this->lastName;
	}

	function setLastName($lastName) {
		$this->lastName = $lastName;
		$result = pg_query(" UPDATE users
			SET last_name = '{$this->lastName}'
			WHERE email = '{$this->email}';");
	}

	function getEmail() {
		return $this->email;
	}

	function setEmail($email) {
		$oldEmail = $this->email;
		$this->email = $email;
		$result = pg_query(" UPDATE users
			SET email = '{$this->email}'
			WHERE email = '{$oldEmail}';");
	}

	function changeEncryptedPassword($password) {
		$securePassword = md5(strip($password));
		$result = pg_query(" UPDATE users
			SET encrypted_password = '{$securePassword}'
			WHERE email = '{$this->email}';");

	}

	/* Static method for the generation of User objects created by the identification of
	unique cookie signatures that are stored on the browser */
	public static function genUserFromCookieID($cookieID) {
		$single_row = pg_query("SELECT u.id, u.first_name, u.last_name, u.email, u.admin
												FROM users u, sessions s
												WHERE u.id = s.id
												AND s.user_session_id = '{$cookieID}';");
		//Ensure query returns exactly one user since composite sessions key pk(id, user_session_id) is unique
		if(pg_num_rows($single_row) == 1) {
			//Cast fetched row to an associative array to harvest user info
			$single_row = pg_fetch_array($single_row, NULL, PGSQL_ASSOC);
			return User::getInstance($single_row['id'], $single_row['first_name'],
				$single_row['last_name'], $single_row['email'], $single_row['admin']);
		} else {
			return NULL;
		}
	}

	/* clear all user sessions so the user will not be persistently remembered */
	function deleteSessions() {
		$delete_operation = pg_query("DELETE FROM sessions
											WHERE id = '{$this->id}'");
	}

	//Generates random bytes that represent 'cookie signature' when user wants to create a new persistent session
	function saveNewSession() {
		//randomly generate number with user email as a salt
		$sig = md5(mt_rand() + $this->email);
		$browser_data = get_browser();
		//We need to ensure this signature doesn't already exist, if it doesn't we can proceed with insertion
		//note that UNIQUE constraint holds on pk(id, user_session_id)
		$result = pg_query("INSERT INTO sessions(id, user_session_id, data)
							VALUES ('{$this->id}', '{$sig}', '{$browser_data}');");

		if(pg_affected_rows($result)==1) {
			return $sig;
		} else {
			//recursively make new sessions until unique signature is generated
			//return $this->saveNewSession();
		}
	}

	//return true if the email has been taken
	public static function doesUserExistWithEmail($email) {
		$result = pg_query("SELECT COUNT(*) FROM users
												WHERE email = '{$email}';");
		if ($line = pg_fetch_assoc($result)) {
    	if($line['count'] == 0) {
     		return false;
    	}
    	else {
    		return true;
    	}
  	}
	}

	//return true if auth token exists
	public static function hasUserAuthenticatedInPast($uid, $access_token) {
		$result = pg_query("SELECT COUNT(*) FROM authentications
												WHERE uid = '{$uid}'
												AND token = '{$access_token}';");

		if ($line = pg_fetch_assoc($result)) {
    	if ($line['rows'] == 0) {
     		return false;
    	}
    	else {
    		return true;
    	}
  	}
	}

	public static function findIDFromEmail($email) {
		$row = pg_query("SELECT id FROM users
											WHERE email = '{$email}';");
		$row = pg_fetch_array($row, NULL, PGSQL_ASSOC);
		return $row['id'];
	}

	public static function fetchAttrWithEmail($email) {
		$row = pg_query("SELECT first_name, last_name, email 
										 FROM users
										 WHERE email = '{$email}';");
		$row = pg_fetch_array($row, NULL, PGSQL_ASSOC);
		return $row;
	}

	public static function addAuthenticationStrategyForUser($email, $platform, $uid, $token) {
		$userId = User::findIDFromEmail($email);
		$result = pg_query("INSERT INTO authentications(id, provider, uid, token)
							VALUES ({$userId},'{$platform}','{$uid}','{$token}');");
		$user_info = User::fetchAttrWithEmail($email);

		return User::getInstance($userId, $user_info['first_name'], 
			$user_info['last_name'], $email, false);
	}
}
?>
