<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// Retrieve a list of countries
// more details on : http://developers.yumpu.com/api/countries/get/
$countries = $yumpu->getCountries();
print_r($countries);

?>