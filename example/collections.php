<?php
// include yumpu sdk
require_once('../yumpu.php');

//make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// collections get example - get all collection
// more details on : http://developers.yumpu.com/api/collections/get-3/
$listColection = $yumpu->getCollections();
print_r($listColection);


// or
// get collections from position 'offset' with limit 'limit' are return only 'return_fields' informations
$data = array(
	'limit' => 1, 
	'offset' => 2,
	'return_fields' => 'id,name'
);
$listColection = $yumpu->getCollections($data);
print_r($listColection);

?>