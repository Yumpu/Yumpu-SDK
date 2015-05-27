<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a member details
// more details on : http://developers.yumpu.com/api/member/get/
// PLEASE USE ONE OF YOUR MEMBER IDS!!!
$data = array(
	'id' => 'WMmFW3L2uDC49sAl'
);
$listMember = $yumpu->getMember($data);
print_r($listMember);


// post/create a new member
// more details on : http://developers.yumpu.com/api/member/post/
$data = array(
    'username' => 'my.username',
    'password' => 'my.passw0rd',
    'comment' => 'comment for my.username'
);
$postMember = $yumpu->postMember($data);
print_r($postMember);



// update a member
// more details on : http://developers.yumpu.com/api/member/put/
$data = array(
    'id' => 'WMmFW3L2uDC49sAl',
    'username' => 'my.username.updated',
    'password' => 'my.passw0rd.updated',
    'comment' => 'comment for my.username updated'
);
$putMember = $yumpu->putMember($data);
print_r($putMember);



// delete an existing member
// more details on : http://developers.yumpu.com/api/member/delete/
// PLEASE USE ONE OF YOUR MEMBER IDS!!!
$id = 'WMmFW3L2uDC49sAl';
$deleteMember = $yumpu->deleteMember($id);
print_r($deleteMember);