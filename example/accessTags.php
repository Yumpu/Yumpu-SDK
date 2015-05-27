<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get accessTags from position 'offset' with limit 'limit'
// more details on : http://developers.yumpu.com/api/access-tags/get/
$data = array(
	'limit' => 10,
    'offset' => 0
);
$listAccessTags = $yumpu->getAccessTags($data);
print_r($listAccessTags);


// get accessTags from position 'offset' with limit 'limit' and sort the result in descending (by name) order and return fields (id,name,default,iap,kiosks)
// more details on : http://developers.yumpu.com/api/access-tags/get/
$data = array(
    'limit' => 10,
    'offset' => 0,
    'return_fields' => 'id,name,default,iap,kiosks',
    'sort' => 'name_desc'
);
$listAccessTags = $yumpu->getAccessTags($data);
print_r($listAccessTags);
?>
