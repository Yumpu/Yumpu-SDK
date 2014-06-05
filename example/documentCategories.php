<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// Retrieve a list of possible documents categories
// more details on : http://developers.yumpu.com/api/document-categories/get/
$categories = $yumpu->getCategories();
print_r($categories);

?>
