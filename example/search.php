<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// Search documents taking into consideration different criterias; q param is required;
// more details on : http://developers.yumpu.com/api/search/get/
$data = array(
	'q' => 'a',
	'sort' => 'create_date_desc'
);
$search = $yumpu->search($data);
print_r($search);

?>
