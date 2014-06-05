<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a collection details
// more details on : http://developers.yumpu.com/api/collection/get-4/
// PLEASE USE ONE OF YOUR COLLECTIONS IDS!!!
$data = array(
	'id' => '65kMP7DSSvd9pNMl',
);
$listCollection = $yumpu->getCollection($data);
print_r($listCollection);


// post/create a new collection 
// more details on : http://developers.yumpu.com/api/collection/post/
$data = array(
	'name' => 'new collection',
);
$newCollection = $yumpu->postCollection($data);
print_r($newCollection);

// put/update an existing collection 
// more details on : http://developers.yumpu.com/api/collection/put-2/
// PLEASE USE ONE OF YOUR COLLECTIONS IDS!!!
$data = array(
	'id'=>'65kMP7DSSvd9pNMl', 
	'name' => 'new collection put'
);
$putCollection = $yumpu->putCollection($data);
print_r($putCollection);

// delete an existing collection 
// more details on : http://developers.yumpu.com/api/collection/delete-2/
// PLEASE USE ONE OF YOUR COLLECTIONS IDS!!!
$id = 'QBCpnSxeWnhUw6mx';
$deleteCollection = $yumpu->deleteCollection($id);
print_r($deleteCollection);

?>
