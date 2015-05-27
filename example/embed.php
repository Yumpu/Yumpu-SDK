<?php
// include yumpu sdk
require_once('../yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

// get embed details
// more details on : http://developers.yumpu.com/api/embed/get/
// PLEASE USE ONE OF YOUR EMBED IDS!!!
$data = array(
	'id' => 'zKtHE23d6R0qT1rf',
);
$listEmbed = $yumpu->getEmbed($data);
print_r($listEmbed);


// post/create a new embed
// more details on : http://developers.yumpu.com/api/embed/post/
$data = array(
    'document_id' => 35151217,
    'type' => 2,
    'width' => 500,
    'background_shape' => 'square',
    'color' => 'grey',
    'destination' => 'magazinePage'
);
$postEmbed = $yumpu->postEmbed($data);
print_r($postEmbed);

// post/create a new embed
// more details on : http://developers.yumpu.com/api/embed/post/
$data = array(
    'document_id' => 35151217,
    'type' => 5,
    'start_page' => 3,
    'title' => 'My book',
    'background_color' => 'CCCCCC',
    'width' => 400,
    'height' => 360,
    'title_font_color' => '000000',
    'download_pdf_enabled' => 'y',
    'download_pdf_title' => 'Download my book',
    'username_enabled' => 'n'
);
$postEmbed = $yumpu->postEmbed($data);
print_r($postEmbed);



// put/update an existing embed
// more details on : http://developers.yumpu.com/api/embed/put/
// PLEASE USE ONE OF YOUR EMBED IDS!!!
$data = array(
	'id'=>'zKtHE23d6R0qT1rf',
    'document_id' => 35151217,
    'type' => 5,
    'start_page' => 1,
    'title' => 'My book',
    'background_color' => '424242',
    'width' => 500,
    'height' => 400,
    'title_font_color' => 'FFFFFF',
    'download_pdf_enabled' => 'n',
    'username_enabled' => 'n'
);
$putEmbed = $yumpu->putEmbed($data);
print_r($putEmbed);



// delete an existing embed
// more details on : http://developers.yumpu.com/api/embed/delete/
// PLEASE USE ONE OF YOUR EMBED IDS!!!
$id = 'zKtHE23d6R0qT1rf';
$deleteEmbed = $yumpu->deleteEmbed($id);
print_r($deleteEmbed);