<?php
// include yumpu sdk
require_once('../yumpu.php');

//make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// embeds get example - get all embeds
// more details on : http://developers.yumpu.com/api/embeds/get/
$listEmbeds = $yumpu->getEmbeds();
print_r($listEmbeds);


// or
// get embeds from position 'offset' with limit 'limit' and return only 'return_fields' informations
$data = array(
	'limit' => 1, 
	'offset' => 2,
	'return_fields' => 'id,type,code,settings'
);
$listEmbeds = $yumpu->getEmbeds($data);
print_r($listEmbeds);

?>