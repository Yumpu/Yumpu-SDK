<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// Retrieve a list of possible languages
// more details on : http://developers.yumpu.com/api/document-languages/get/
$laguages = $yumpu->getLanguages();
print_r($laguages);

?>
