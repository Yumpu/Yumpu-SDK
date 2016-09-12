<?php
// include yumpu sdk
require_once('../yumpu.php');

//make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get one document hotspot
// more details on : http://developers.yumpu.com/api/document-hotspot/get/
$data = array(
    'id' => '02784dc6chuNtFd2'
);
$hotspot = $yumpu->getDocumentHotspot($data);
print_r($hotspot);

// post one document hotspot
// more details on : http://developers.yumpu.com/api/document-hotspot/post/
$data = array(
    'document_id' => '55919352',
    'page' => '1',
    'type' => 'link',
    'settings' => array(
        'x' => 100,
        'y' => 100,
        'w' => 20,
        'h' => 20,
        'name' => 'google.com',
        'tooltip' => 'google.com',
        'link' => 'https://www.yumpu.com'
    )
);
$hotspot = $yumpu->postDocumentHotspot($data);
print_r($hotspot);

// post one document hotspot
// more details on : http://developers.yumpu.com/api/document-hotspot/put/
$data = array(
    'id' => '02784dc6chuNtFd2',
    'type' => 'link',
    'settings' => array(
        'x' => 200,
        'y' => 200,
        'w' => 20,
        'h' => 20,
        'name' => 'google.com',
        'tooltip' => 'google.com',
        'link' => 'https://www.yumpu.com'
    )
);
$hotspot = $yumpu->putDocumentHotspot($data);
print_r($hotspot);

// delete one document hotspot
// more details on : http://developers.yumpu.com/api/document-hotspot/put/
$id = '02784dc6chuNtFd2';
$response = $yumpu->deleteDocumentHotspot($id);
print_r($response);