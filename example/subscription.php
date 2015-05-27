<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a subscription details
// more details on : http://developers.yumpu.com/api/subscription/get/
// PLEASE USE ONE OF YOUR SUBSCRIPTION IDS!!!
$data = array(
	'id' => 'WMmFW3L2uDC49sAl'
);
$listSubscription = $yumpu->getSubscription($data);
print_r($listSubscription);


// post/create a new subscription
// more details on : http://developers.yumpu.com/api/subscription/post/
$data = array(
    'itc_product_id' => 'my_subscription_itc_product_id',
    'name' => 'my subscription name',
    'duration' => 365,
    'description' => 'my subscription description',
);
$postSubscription = $yumpu->postSubscription($data);
print_r($postSubscription);



// update a subscription
// more details on : http://developers.yumpu.com/api/subscription/put/
$data = array(
    'id' => 'WMmFW3L2uDC49sAl',
    'itc_product_id' => 'my_subscription_itc_product_id_updated',
    'name' => 'my subscription name updated',
    'duration' => 7,
    'description' => 'my subscription description updated',
);
$putSubscription = $yumpu->putSubscription($data);
print_r($putSubscription);



// delete an existing subscription
// more details on : http://developers.yumpu.com/api/subscription/delete/
// PLEASE USE ONE OF YOUR SUBSCRIPTION IDS!!!
$id = 'WMmFW3L2uDC49sAl';
$deleteSubscription = $yumpu->deleteSubscription($id);
print_r($deleteSubscription);