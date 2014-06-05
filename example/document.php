<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a document details
// more details on : http://developers.yumpu.com/api/document/get-2/
// PLEASE USE ONE OF YOUR DOCUMENTS IDS!!!
$data = array(
	'id' => 24975453, 
	'return_fields' => 'id,create_date,update_date,url,image_small'
);
$listDocument = $yumpu->getDocument($data);
print_r($listDocument);

// document post url example without page_teaser_image
// more details on : http://developers.yumpu.com/api/document/post-url/
$data = array(
	'title' => 'about yumpu sdk',
	'url' => 'https://s3-eu-west-1.amazonaws.com/yumpu/api/yumpu_sdk_example_pdf.pdf',
);

$newDocument = $yumpu->postDocumentUrl($data);
print_r($newDocument);

// document post url example with page_teaser_image
// more details on : http://developers.yumpu.com/api/document/post-url/
$data = array(
	'title' => 'about yumpu sdk with page teaser',
	'url' => 'https://s3-eu-west-1.amazonaws.com/yumpu/api/yumpu_sdk_example_pdf.pdf',
	'page_teaser_image' => dirname(__FILE__).'/media/'.'yumpu.png',
	'page_teaser_page_range' => '1-1',
	'page_teaser_url' => 'http://www.yumpu.com/en'
);

$newDocument = $yumpu->postDocumentUrl($data);
print_r($newDocument);

// document post file example without page_teaser_image; for file will be used full path
// more details on : http://developers.yumpu.com/api/document/post-file/
$data = array(
	'title' => 'about yumpu sdk file',
	'file' =>  dirname(__FILE__).'/media/'.'yumpu.pdf',
);
$newDocument = $yumpu->postDocumentFile($data);
print_r($newDocument);

// document post file example with page_teaser_image; for file will be used full path
// more details on : http://developers.yumpu.com/api/document/post-file/
$data = array(
	'title' => 'about yumpu sdk file with page teaser',
	'file' =>  dirname(__FILE__).'/media/'.'yumpu.pdf',
	'page_teaser_image' => dirname(__FILE__).'/media/'.'yumpu.png',
	'page_teaser_page_range' => '1-1',
	'page_teaser_url' => 'http://www.yumpu.com/en'
);
$newDocument = $yumpu->postDocumentFile($data);
print_r($newDocument);

// put/update an existing document 
// more details on : http://developers.yumpu.com/api/document/put/
// PLEASE USE ONE OF YOUR DOCUMENTS IDS!!!
$data = array(
	'id' => 24975453,  
	'title' => 'put new about yumpu sdk',
	'description' => 'put new about yumpu sdk description'
);
$putDocument = $yumpu->putDocument($data);
print_r($putDocument);

// delete an existing document
// more details on : http://developers.yumpu.com/api/document/delete/
// PLEASE USE ONE OF YOUR DOCUMENTS IDS!!!
$id = 24952680;
$deleteDocument = $yumpu->deleteDocument($id);
print_r($deleteDocument);
?>
