<?php

	if(isset($_GET['platform'])){
		require_once 'vendor/autoload.php';
		require_once 'php/User.php';
		require_once 'php/functions.php';
		require_once 'php/connect.php';


		//start session so third party libraries don't throw a CSRF exception
		session_name('NUSRiders');
		session_set_cookie_params(2*7*24*60*60);
		session_start();

		$strategy = $_GET['platform'];
			//enable session so third-party platforms will not throw a CSRF exception

		switch($strategy) {

			//Authnetication strategy for handling facebook callbacks
			case "facebook":

				$fb = new Facebook\Facebook([
				  'app_id' => '809214045880779', // Replace {app-id} with your app id
				  'app_secret' => '35c1d3f291437b66b8977992a0e70653',
				  'default_graph_version' => 'v2.2',
				  ]);

				$helper = $fb->getRedirectLoginHelper();

				try {
				  $accessToken = $helper->getAccessToken();
				  $response = $fb->get('/me?fields=id,first_name,last_name,email', $accessToken);

				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  // When Graph returns an error
				  echo 'Graph returned an error: ' . $e->getMessage();
				  exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  // When validation fails or other local issues
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
				}

				if (!isset($accessToken)) {
				  if ($helper->getError()) {
				    header('HTTP/1.0 401 Unauthorized');
				    echo "Error: " . $helper->getError() . "\n";
				    echo "Error Code: " . $helper->getErrorCode() . "\n";
				    echo "Error Reason: " . $helper->getErrorReason() . "\n";
				    echo "Error Description: " . $helper->getErrorDescription() . "\n";
				  } else {
				    header('HTTP/1.0 400 Bad Request');
				    echo 'Bad request';
				  }
				  exit;
				} else {
					$user = $response->getGraphUser();
					$token = (string) $accessToken;
					$user_info = array("uid" => $user['id'], "token"=> $token, "email"=>$user['email'],
					"first_name" => $user['first_name'], "last_name" => $user['last_name'], "platform" => $strategy);
					$user = userFromThirdPartyPlatform($user_info);

					if(is_null($user)) {
						header("Location: login.php");
					} else {
						header("Location: index.php");
					}
				}
				break;
		}


	} else {
		require_once 'vendor/autoload.php';
	}

	function fetchLoginLink($platform) {
		switch($platform){

			//Generating custom Facebook link for user authentication
			case "facebook":

				$fb = new Facebook\Facebook([
  				'app_id' => '809214045880779', // Replace {app-id} with your app id
  				'app_secret' => '35c1d3f291437b66b8977992a0e70653',
  				'default_graph_version' => 'v2.2',
  				]);

				$helper = $fb->getRedirectLoginHelper();

				$permissions = ['email', 'public_profile']; // Optional permissions
				$loginUrl = $helper->getLoginUrl('http://localhost:8888/NUSriders3/platform_login_strategies.php?platform=facebook', $permissions);
				return htmlspecialchars($loginUrl);
				break;

			//Generating custom Linkedin link for user authentication
			case "linkedin":

				break;

			//Generating custom Google link for user authentication
			case "google":

				break;

			default:
				return NULL;

		}

		return NULL;
	}

?>
