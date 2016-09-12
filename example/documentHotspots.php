<?php
// include yumpu sdk
require_once('../yumpu.php');

//make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// documentHotspots get example - get all documentHotspots
// more details on : http://developers.yumpu.com/api/document-hotspots/get/
$data = array(
    'id' => '55929790'
);
$listHotspots = $yumpu->getDocumentHotspots($data);
print_r($listHotspots);
