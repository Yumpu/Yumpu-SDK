<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get an accessTag details
// more details on : http://developers.yumpu.com/api/access-tag/get/
// PLEASE USE ONE OF YOUR ACCESS-TAG IDS!!!
$data = array(
	'id' => 'AxIXH5M2JUa7nu9j',
);
$listAccesstag = $yumpu->getAccessTag($data);
print_r($listAccesstag);


// post/create a new access-tag
// more details on : http://developers.yumpu.com/api/access-tag/post/
$data = array(
	'name' => 'new access-tag',
    'description' => 'new access-tag description',
    'default' => 'y'
);
$newaccessTag = $yumpu->postAccessTag($data);
print_r($newaccessTag);


// put/update an existing collection 
// more details on : http://developers.yumpu.com/api/collection/put/
// PLEASE USE ONE OF YOUR ACCESS-TAG IDS!!!
$data = array(
	'id'=>'AxIXH5M2JUa7nu9j',
	'name' => 'new access-tag put'
);
$putAccessTag = $yumpu->putAccessTag($data);
print_r($putAccessTag);



// delete an existing access-tag
// more details on : http://developers.yumpu.com/api/access-tag/delete/
// PLEASE USE ONE OF YOUR ACCESS-TAG IDS!!!
$id = 'AxIXH5M2JUa7nu9j';
$deleteAccessTag = $yumpu->deleteAccessTag($id);
print_r($deleteAccessTag);


?>
