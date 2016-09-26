<?php

// include yumpu sdk
require_once('yumpu.php');
require_once('config.php');

// make an instance of the Yumpu sdk class;
$yumpu = new Yumpu();

if ($config[token] == 'yourToken') {
    print_r("<p style='font-family: Arial;font-weight: bold'>You have forgotten to set your token!</p>");
    die();
}

// define the input (only small characters, no symbols, no blank spaces, min 5 characters)
$testInput = 'inputfortest';
$testInputPut = $testInput . 'put';

$successCount = 0;
$errorCount = 0;

echo "<h1 style='font-family: Arial'>Tests for the yumpu php sdk:</h1><ul>";

// Test for the getCountries function
$getCountries = $yumpu->getCountries();
echo $getCountries;
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

$cnt = 0;
function documentProgressUrl($documentProgressIdUrl)
{
    global $yumpu, $cnt;
//    print_r($documentProgressIdUrl);

    $progressId = $documentProgressIdUrl;
    $getDocumentProgress = $yumpu->getDocumentProgress($progressId);
    if ($getDocumentProgress[document][state] == 'rendering_in_progress') {
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
    if ($getDocumentProgress[document][state] == 'rendering_in_progress') {
        $cnt = $cnt + 1;
        if ($cnt >= 10) {
            check('failed', 'getDocumentProgressFile');
        }
        sleep(2);
        documentProgressFile($documentProgressIdFile);

    } else {
        check($getDocumentProgress[state], 'getDocumentProgressFile');
        $documentIdFile = $getDocumentProgress[document][0][id];
        search($documentIdFile);
    }
}

$cntSearch = 0;
function search($documentIdFile)
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
        search($documentIdFile);
    } else {
        check($search[state], 'search');

        // Test for the deleteDocument function
        $id = $documentIdFile;
        $deleteDocument = $yumpu->deleteDocument($id);
        check($deleteDocument[state], 'deleteDocumentFile');
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

    // Test for the postEmbed function
    $params = array(
        'document_id' => $documentIdUrl,
        'type' => 2
    );
    $postEmbed = $yumpu->postEmbed($params);
    if (check($postEmbed[state], 'postEmbed')) {
        $embedId = $postEmbed[embed][id];
        whenEmbedBuilt($embedId, $documentIdUrl);
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

    // Test for the deleteDocumentHotspot function
    $id = $documentHotspotId;
    $deleteDocumentHotspot = $yumpu->deleteDocumentHotspot($id);
    check($deleteDocumentHotspot[state], 'deleteDocumentHotspot');
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
    $idCollectionSection = $collectionId . '_' . $sectionId;

    // Test for the getSection function
    $params = array(
        'id' => $idCollectionSection
    );
    $getSection = $yumpu->getSection($params);
    check($getSection[state], 'getSection');

    // Test for the putSeciton function
    $params = array(
        'id' => $idCollectionSection,
        'name' => $testInputPut,
        'description' => $testInputPut
    );
    $putSection = $yumpu->putSection($params);
    check($putSection[state], 'putSection');

    // Test for the postSectionDocument function
    $data = array(
        'id' => $idCollectionSection,
        'documents' => $documentIdUrl
    );
    $postSectionDocument = $yumpu->postSectionDocument($data);
    check($postSectionDocument[state], 'postSectionDocument');

    // Test for the deleteSectionDocument function
    $data = array(
        'id' => $idCollectionSection,
        'documents' => $documentIdUrl
    );
    $deleteSectionDocument = $yumpu->deleteSectionDocument($data);
    check($deleteSectionDocument[state], 'deleteSectionDocument');

    // Test for the deleteSection function
    $id = $idCollectionSection;
    $deleteSection = $yumpu->deleteSection($id);
    check($deleteSection[state], 'deleteSection');

    // Test for the deleteCollection function
    $id = $collectionId;
    $deleteCollection = $yumpu->deleteCollection($id);
    check($deleteCollection[state], 'deleteCollection');

}

function whenEmbedBuilt($embedId, $documentIdUrl)
{
    global $yumpu, $testInput, $testInputPut;

    // Test for the getEmbed function
    $params = array(
        'id' => $embedId
    );
    $getEmbed = $yumpu->getEmbed($params);
    check($getEmbed[state], 'getEmbed');

    // Test for the getEmbeds function
    $params = array(
        'limit' => 1
    );
    $getEmbeds = $yumpu->getEmbeds($params);
    check($getEmbeds[state], 'getEmbeds');

    // Test for the putEmbed function
    $params = array(
        'id' => $embedId,
        'document_id' => $documentIdUrl,
        'type' => 2,
        'background_shape' => 'square'
    );
    $putEmbed = $yumpu->putEmbed($params);
    check($putEmbed[state], 'putEmbed');

    // Test for the deleteEmbed function
    $id = $embedId;
    $deleteEmbed = $yumpu->deleteEmbed($id);
    check($deleteEmbed[state], 'deleteEmbed');

    // Test for the deleteDocument function
    $id = $documentIdUrl;
    $deleteDocument = $yumpu->deleteDocument($id);
    check($deleteDocument[state], 'deleteDocumentUrl');
}

// Test for the postMember function
$params = array(
    'username' => $testInput,
    'password' => '9609ff2e7ba4d577161ab075e406b97f'
);
$postMember = $yumpu->postMember($params);
if (check($postMember[state], 'postMember')) {
    $memberId = $postMember[member][id];
    whenMemberBuilt($memberId);
}

function whenMemberBuilt($memberId)
{
    global $yumpu, $testInputPut;

    // Test for the getMembers fucntion
    $params = array(
        'limit' => 10,
        'offset' => 0
    );
    $getMembers = $yumpu->getMembers($params);
    check($getMembers[state], 'getMembers');

    // Test for the getMember function
    $params = array(
        'id' => $memberId
    );
    $getMember = $yumpu->getMember($params);
    check($getMember[state], 'getMember');

    // Test for the putMember function
    $params = array(
        'id' => $memberId,
        'username' => $testInputPut,
        'password' => '9609ff2e7ba4d577161ab075e406b97f'
    );
    $putMember = $yumpu->putMember($params);
    check($putMember[state], 'putMember');

    // Test for the deleteMember function
    $id = $memberId;
    $deleteMember = $yumpu->deleteMember($id);
    check($deleteMember[state], 'deleteMember');
}

// Test for the postAccessTag function
$params = array(
    'name' => $testInput,
    'description' => $testInput
);
$postAccessTag = $yumpu->postAccessTag($params);
if (check($postAccessTag[state], 'postAccessTag')) {
    $accessTagId = $postAccessTag[access_tag][id];
    whenAccessTagBuilt($accessTagId);
}

function whenAccessTagBuilt($accessTagId)
{
    global $yumpu, $testInputPut;

    // Test for the getAccessTags function
    $params = array(
        'limit' => 10,
        'offset' => 0
    );
    $getAccessTags = $yumpu->getAccessTags($params);
    check($getAccessTags[state], 'getAccessTags');

    // Test for the getAccessTag function
    $params = array(
        'id' => $accessTagId,
    );
    $getAccessTag = $yumpu->getAccessTag($params);
    check($getAccessTag[state], 'getAccessTag');

    // Test for the putAccessTag function
    $params = array(
        'id' => $accessTagId,
        'name' => $testInputPut
    );
    $putAccessTag = $yumpu->putAccessTag($params);
    check($putAccessTag[state], 'putAccessTag');

    // Test for the deleteAccessTag function
    $id = $accessTagId;
    $deleteAccessTag = $yumpu->deleteAccessTag($id);
    check($deleteAccessTag[state], 'deleteAccessTag');
}

// Test for the postSubscription function
$params = array(
    'itc_product_id' => $testInput,
    'name' => $testInput,
    'duration' => 365
);
$postSubscription = $yumpu->postSubscription($params);
if (check($postSubscription[state], 'postSubscription')) {
    $subscriptionId = $postSubscription[subscription][id];
    whenSubscriptionBuilt($subscriptionId);
}

function whenSubscriptionBuilt($subscriptionId)
{
    global $yumpu, $testInputPut;

    // Test for the getSubscriptions function
    $params = array(
        'limit' => 10,
        'offset' => 0
    );
    $getSubscriptions = $yumpu->getSubscriptions($params);
    check($getSubscriptions[state], 'getSubscriptions');

    // Test for the getSubscription function
    $params = array(
        'id' => $subscriptionId
    );
    $getSubscription = $yumpu->getSubscription($params);
    check($getSubscription[state], 'getSubscription');

    // Test for the putSubscription function
    $params = array(
        'id' => $subscriptionId,
        'itc_product_id' => $testInputPut,
        'name' => $testInputPut,
        'duration' => 7
    );
    $putSubscription = $yumpu->putSubscription($params);
    check($putSubscription[state], 'putSubscription');

    // Test for the deleteSubscription function
    $id = $subscriptionId;
    $deleteSubscription = $yumpu->deleteSubscription($id);
    check($deleteSubscription[state], 'deleteSubscription');
}

function check($state, $name)
{
    global $successCount, $errorCount;
    if ($state == 'success') {
        $successCount++;
        print_r("<li style='font-family: Arial'><span style='color:green'>" . $state . "</span> - " . $name . " ----- " . $successCount . " successful tests" . "</li>");
        return true;
    } else {
        $errorCount++;
        print_r("<li style='font-family: Arial'><span style='color:red'>" . $state . "</span> - " . $name . " ----- " . $errorCount . " error tests" . "</li>");
        return false;
    }
}

echo "</ul>";
if ($successCount == 51) {
    echo "<p style='font-weight: bold; font-family: Arial'>" . $successCount . " tests done - everything works</p>";
} else {
    $error = 'A test went wrong ' . $name;
    throw new Exception($error);
}