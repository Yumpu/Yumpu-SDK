<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get subscriptions from position 'offset' with limit 'limit'
// more details on : http://developers.yumpu.com/api/subscriptions/get/
$data = array(
	'limit' => 10,
    'offset' => 0
);
$listSubscriptions = $yumpu->getSubscriptions($data);
print_r($listSubscriptions);


// get subscriptions from position 'offset' with limit 'limit' and sort the result in ascending (by name) order and return fields (id,itc_product_id,name,description,duration,create_date)
// more details on : http://developers.yumpu.com/api/subscriptions/get/
$data = array(
    'limit' => 10,
    'offset' => 0,
    'return_fields' => 'id,itc_product_id,name,description,duration,create_date',
    'sort' => 'name_asc'
);
$listSubscriptions = $yumpu->getSubscriptions($data);
print_r($listSubscriptions);
?>
