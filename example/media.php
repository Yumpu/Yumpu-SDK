<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a media details
// more details on : http://developers.yumpu.com/api/media/get/
// PLEASE USE ONE OF YOUR MEDIA IDS!!!
$data = array(
	'id' => 'WMmFW3L2uDC49sAl',
);
$listMedia = $yumpu->getMedia($data);
print_r($listMedia);


// post/create a new media
// more details on : http://developers.yumpu.com/api/media/post/
$data = array(
    'file' =>  dirname(__FILE__).'/media/'.'yumpu.png',
);
$newMedia = $yumpu->postMedia($data);
print_r($newMedia);



// put/update an existing media
// more details on : http://developers.yumpu.com/api/media/put/
// PLEASE USE ONE OF YOUR MEDIA IDS!!!
$data = array(
	'id'=>'WMmFW3L2uDC49sAl',
	'description' => 'new media Put'
);
$putMedia = $yumpu->putMedia($data);
print_r($putMedia);



// delete an existing Media
// more details on : http://developers.yumpu.com/api/media/delete/
// PLEASE USE ONE OF YOUR MEDIA IDS!!!
$id = 'WMmFW3L2uDC49sAl';
$deleteMedia = $yumpu->deleteMedia($id);
print_r($deleteMedia);