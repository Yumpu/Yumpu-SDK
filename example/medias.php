<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get medias from position 'offset' with limit 'limit'
// more details on : http://developers.yumpu.com/api/medias/get/
$data = array(
	'limit' => 10,
    'offset' => 0
);
$listMedias = $yumpu->getMedias($data);
print_r($listMedias);


// get medias from position 'offset' with limit 'limit' and sort the result in descending order and return fields (id, name, url, size, mime_type)
// more details on : http://developers.yumpu.com/api/medias/get/
$data = array(
    'limit' => 10,
    'offset' => 0,
    'return_fields' => 'id,name,url,size,mime_type',
    'sort' => 'desc'
);
$listMedias = $yumpu->getMedias($data);
print_r($listMedias);
?>
