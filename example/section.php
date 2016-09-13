<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get a section details
// more details on : http://developers.yumpu.com/api/section/get-5/
// PLEASE USE ONE OF YOUR SECTIONS IDS!!!
$data = array(
	'id'=>'JEy5UQXbKJOVmfif_V2xvUpIjCVeLqMbl',
);
$section = $yumpu->getSection($data);
print_r($section);


// post/create a new section 
// more details on : http://developers.yumpu.com/api/section/post-2/
$data = array(
	'id'=>'JEy5UQXbKJOVmfif', // one of your collections id
	'name' => 'new section',
);
$newSection = $yumpu->postSection($data);
print_r($newSection);

// put/update an existing section 
// more details on : http://developers.yumpu.com/api/section/put-3/
// PLEASE USE ONE OF YOUR SECTIONS IDS!!!
$data = array(
	'id'=>'JEy5UQXbKJOVmfif_V2xvUpIjCVeLqMbl', 
	'name' => 'new section put',
	'description' => ''
);
$putSection = $yumpu->putSection($data);
print_r($putSection);

// delete an existing section 
// more details on : http://developers.yumpu.com/api/section/delete-3/
// PLEASE USE ONE OF YOUR SECTIONS IDS!!!
$id = 'JEy5UQXbKJOVmfif_ZOvQeWYhu901LS2q';
$deleteSection = $yumpu->deleteSection($id);
print_r($deleteSection);

?>
