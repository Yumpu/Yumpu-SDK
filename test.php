<?php

// include yumpu sdk
require_once('yumpu.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

$testInput = 'inputfortestxy';
$testInputPut = $testInput . 'put';

$successCount = 0;
$errorCount = 0;

// Test for the getCountries function
$getCountries = $yumpu->getCountries();
if (check($getCountries[state], 'getCountries')) ;

// Test for the getDocumentLanguages function
$getDocumentLanguages = $yumpu->getLanguages();
check($getDocumentLanguages[state], 'getDocumentLanguages');

// Test for the getDocumentCategories function
$getDocumentCategories = $yumpu->getCategories();
check($getDocumentCategories[state], 'getDocumentCategories');

// Test for the getUser function
$params = '';
$getUser = $yumpu->getUser($params);
check($getUser[state], 'getUser');

// Test for the putUser function
$params = array(
    'language' => 'en'
);
$putUser = $yumpu->putUser($params);
check($putUser[state], 'putUser');

// Test for the postDocumentUrl function
$params = array(
    'title' => $testInput,
    'url' => 'http://www.onlinemarketing-praxis.de/uploads/pdf/suchparameter-google-uebersicht.pdf'
);
$postDocumentUrl = $yumpu->postDocumentUrl($params);
if (check($postDocumentUrl[state], 'postDocumentUrl')) {
    $documentProgressIdUrl = $postDocumentUrl[progress_id];
    documentProgressUrl($documentProgressIdUrl);
}

// Test for the postDocumentFile function
$params = array(
    'title' => 'TestSearchDocument',
    'file' => dirname(__FILE__) . '/example/media/' . 'yumpu.pdf',
    'page_teaser_image' => dirname(__FILE__) . '/example/media/' . 'yumpu.png',
    'page_teaser_page_range' => '1-1',
    'page_teaser_url' => 'http://www.yumpu.com/en'
);
$postDocumentFile = $yumpu->postDocumentFile($params);
if (check($postDocumentFile[state], 'postDocumentFile')) {
    $documentProgressIdFile = $postDocumentFile[progress_id];
    documentProgressFile($documentProgressIdFile);
}

/**
 *
 */
function documentProgressUrl($documentProgressIdUrl)
{
    global $yumpu;
//    print_r($documentProgressIdUrl);
    $cnt = 0;
    $progressId = $documentProgressIdUrl;
    $getDocumentProgress = $yumpu->getDocumentProgress($progressId);
    if ($getDocumentProgress[document][state] == rendering_in_progress) {
        $cnt = $cnt + 1;
        if ($cnt >= 10) {
            check('failed', 'getDocumentProgressUrl');
        }
        sleep(2);
        documentProgressUrl($documentProgressIdUrl);

    } else {
        check($getDocumentProgress[state], 'getDocumentProgressUrl');
        $documentIdUrl = $getDocumentProgress[document][0][id];
        whenDocumentBuilt($documentIdUrl);
    }
}

function documentProgressFile($documentProgressIdFile)
{
    global $yumpu;
    $cnt = 0;
    $progressId = $documentProgressIdFile;
    $getDocumentProgress = $yumpu->getDocumentProgress($progressId);
    if ($getDocumentProgress[document][state] == rendering_in_progress) {
        $cnt = $cnt + 1;
        if ($cnt >= 10) {
            check('failed', 'getDocumentProgressFile');
        }
        sleep(2);
        documentProgressFile($documentProgressIdFile);

    } else {
        check($getDocumentProgress[state], 'getDocumentProgressFile');
        search();
    }
}

$cntSearch = 0;
function search()
{
    global $cntSearch, $yumpu;
    $params = array(
        'q' => 'TestSearchDocument',
        'in' => 'title'
    );
    $search = $yumpu->search($params);
    if ($search[state] != 'success') {
        $cntSearch = $cntSearch + 1;
        if ($cntSearch > 30) {
            check('failed', 'search');
        }
        sleep(2);
        search();
    } else {
        check($search[state], 'search');
    }
}

function whenDocumentBuilt($documentIdUrl)
{
    global $yumpu, $testInput, $testInputPut;

    // Test for the getDocument function
    $params = array(
        'id' => $documentIdUrl
    );
    $getDocument = $yumpu->getDocument($params);
    check($getDocument[state], 'getDocument');

    // Test for the getDocuments function
    $params = array(
        'limit' => 1
    );
    $getDocuments = $yumpu->getDocuments($params);
    check($getDocuments[state], 'getDocuments');

    // Test for the putDocument function
    $params = array(
        'id' => $documentIdUrl,
        'title' => $testInputPut
    );
    $putDocument = $yumpu->putDocument($params);
    check($putDocument[state], 'putDocument');

    // Test for the postDocumentHotspot function
    $params = array(
        'document_id' => $documentIdUrl,
        'page' => '1',
        'type' => 'link',
        'settings' => array(
            'x' => 100,
            'y' => 100,
            'w' => 20,
            'h' => 20,
            'name' => $testInput,
            'tooltip' => $testInput,
            'link' => 'https://www.yumpu.com'
        )
    );
    $postDocumentHotspot = $yumpu->postDocumentHotspot($params);
    if (check($postDocumentHotspot[state], 'postDocumentHotspot')) {
        $documentHotspotId = $postDocumentHotspot[hotspot][0][id];
        whenDocumentHotspotBuilt($documentHotspotId, $documentIdUrl);
    }

    // Test for the postCollection function
    $params = array(
        'name' => $testInput,
    );
    $postCollection = $yumpu->postCollection($params);
    if (check($postCollection[state], 'postCollection')) {
        $collectionId = $postCollection[collection][0][id];
        whenCollectionBuilt($collectionId, $documentIdUrl);
    }
}

function whenDocumentHotspotBuilt($documentHotspotId, $documentIdUrl)
{
    global $yumpu, $testInput, $testInputPut;

    // Test for the getDocumentHotspot function
    $params = array(
        'id' => $documentHotspotId
    );
    $getDocumentHotspot = $yumpu->getDocumentHotspot($params);
    check($getDocumentHotspot[state], 'getDocumentHotspot');

    // Test for the getDocumentHotspots function
    $params = array(
        'id' => $documentIdUrl,
        'limit' => 5
    );
    $getDocumentHotspots = $yumpu->getDocumentHotspots($params);
    check($getDocumentHotspots[state], 'getDocumentHotspots');

    // Test for the putDocumentHotspot function
    $params = array(
        'id' => $documentHotspotId,
        'type' => 'link',
        'settings' => array(
            'x' => 200,
            'y' => 200,
            'w' => 20,
            'h' => 20,
            'name' => $testInputPut,
            'tooltip' => $testInputPut,
            'link' => 'https://www.yumpu.com'
        )
    );
    $putDocumentHotspot = $yumpu->putDocumentHotspot($params);
    check($putDocumentHotspot[state], 'putDocumentHotspot');


}

function whenCollectionBuilt($collectionId, $documentIdUrl)
{
    global $yumpu, $testInput, $testInputPut;

    // Test for the getCollections functiono
    $getCollections = $yumpu->getCollections();
    check($getCollections[state], 'getCollections');

    // Test for the getCollection function
    $params = array(
        'id' => $collectionId,
    );
    $getCollection = $yumpu->getCollection($params);
    check($getCollection[state], 'getColection');

    // Test for the putCollection function
    $params = array(
        'id' => $collectionId,
        'name' => $testInputPut
    );
    $putCollection = $yumpu->putCollection($params);
    check($putCollection[state], 'putCollection');

    // Test for the postSection function
    $params = array(
        'id' => $collectionId,
        'name' => $testInput
    );
    $postSection = $yumpu->postSection($params);
    if (check($postSection[state], 'postSection')) {
        $sectionId = $postSection[section][0][id];
        whenSectionBuilt($sectionId, $collectionId, $documentIdUrl);
    }
}

function whenSectionBuilt($sectionId, $collectionId, $documentIdUrl)
{
    global $yumpu, $testInputPut;
    $id = $collectionId . '_' . $sectionId;

    // Test for the getSection function
    $params = array(
        'id' => $id
    );
    $getSection = $yumpu->getSection($params);
    check($getSection[state], 'getSection');

    // Test for the putSeciton function
    $params = array(
        'id' => $id,
        'name' => $testInputPut,
        'description' => $testInputPut
    );
    $putSection = $yumpu->putSection($params);
    check($putSection[state], 'putSection');

    // Test for the postSectionDocument function
    $data = array(
        'id' => $id,
        'documents' => $documentIdUrl
    );
    $postSectionDocument = $yumpu->postSectionDocument($data);
    check($postSectionDocument[state], 'postSectionDocument');
}

function check($state, $name)
{
    global $successCount, $errorCount;
    if ($state == 'success') {
        $successCount++;
        print_r($state . ' - ' . $name . ' ----- ' . $successCount . ' successful tests' . '<br/>');
        return true;
    } else {
        $errorCount++;
        echo 'error - ' . $name . ' ----- ' . $errorCount . ' error tests';
        return false;
    }
}
