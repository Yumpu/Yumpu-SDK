<?php
// include yumpu sdk
require_once('../yumpu.php');

//make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// documents get example - get all documents 
// more details on : http://developers.yumpu.com/api/documents/get/
$listDocument = $yumpu->getDocuments();
print_r($listDocument);


// or
// get document from position 'offset' with limit 'limit'
$data = array(
	'limit' => 1, 
	'offset' => 2
);
$listDocument = $yumpu->getDocuments($data);
print_r($listDocument);

?>
