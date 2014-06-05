<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a document details
// more details on : http://developers.yumpu.com/api/document-progress/get/
// PLEASE USE ONE OF YOUR PROGRESS IDS
$progressId = '9e2a4-4dc9e-05c78-8dd61-e1afc-fb090-4405b-9469e';
$documentProgess = $yumpu->getDocumentProgress($progressId);
print_r($documentProgess);
?>
