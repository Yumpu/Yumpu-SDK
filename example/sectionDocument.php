<?php
// include yumpu sdk
require_once('../yumpu.php');

//make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// Create a new document in section
// more details on : http://developers.yumpu.com/api/section-document/post-3/
// PLEASE USE ONE OF YOUR SECTIONS & DOCUMENTS IDS!!!
$data = array(
	'id' => 'JEy5UQXbKJOVmfif_V2xvUpIjCVeLqMbl', 
	'documents' => '24825704'
);
$sectionDocument = $yumpu->postSectionDocument($data);
print_r($sectionDocument);

// Delete a document in section
// more details on : http://developers.yumpu.com/api/section-document/delete-4/
// PLEASE USE ONE OF YOUR SECTIONS & DOCUMENTS IDS!!!
$data = array(
	'id' => 'JEy5UQXbKJOVmfif_V2xvUpIjCVeLqMbl', 
	'documents' => '24825704'
);
$deleteSectionDocument = $yumpu->deleteSectionDocument($data);
print_r($deleteSectionDocument);

?>
