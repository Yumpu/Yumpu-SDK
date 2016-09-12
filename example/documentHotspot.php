<?php
// include yumpu sdk
require_once('../yumpu.php');

//make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get one document hotspot
// more details on : http://developers.yumpu.com/api/document-hotspot/get/
$data = array(
    'id' => '295bea83BMG4DfeZ'
);
$hotspot = $yumpu->getDocumentHotspot($data);
print_r($hotspot);
