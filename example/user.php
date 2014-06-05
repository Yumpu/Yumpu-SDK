<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a user details
// more details on : http://developers.yumpu.com/api/user/get/

$getUser = $yumpu->getUser();
print_r($getUser);

// OR 
// use another token that the one set in config
$data = array(
	'token' => 'value of the token'
);
$getUser = $yumpu->getUser($data);
print_r($getUser);

// post/create a new user profile
// more details on : http://developers.yumpu.com/api/user/post/
// PLEASE USE A VALID EMAIL & USERNAME!!!
$data = array(
	'email' => 'your user@domain.com', 
	'username' => 'newuser', 
	'password' => 'newpassword'
);
$newUser = $yumpu->postUser($data);
print_r($newUser);

// put/update an existing user 
// more details on : http://developers.yumpu.com/api/user/put/
$data = array(
	'gender' => 'female', 
	'firstname' => 'my FirstName', 
	'lastname' => 'my LastName'
);
$putUser = $yumpu->putUser($data);
print_r($putUser);


?>
