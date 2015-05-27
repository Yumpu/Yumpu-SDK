<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get members from position 'offset' with limit 'limit'
// more details on : http://developers.yumpu.com/api/members/get/
$data = array(
	'limit' => 10,
    'offset' => 0
);
$listMembers = $yumpu->getMembers($data);
print_r($listMembers);


// get members from position 'offset' with limit 'limit' and sort the result in descending (by create date) order and return fields (id,username,access_tags,kiosks)
// more details on : http://developers.yumpu.com/api/members/get/
$data = array(
    'limit' => 10,
    'offset' => 0,
    'return_fields' => 'id,username,access_tags,kiosks',
    'sort' => 'create_date_desc'
);
$listMembers = $yumpu->getMembers($data);
print_r($listMembers);
?>
