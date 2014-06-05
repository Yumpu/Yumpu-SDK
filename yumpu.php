<?php
/**
 * Integration of Yumpu API methods; http://developers.yumpu.com/ API methods;
 *
 * @author artsoft-consult.ro
 */
require_once('config.php');

class Yumpu {
	/**
	 * @var array yumpuEndpoints ; the api available methods for yumpu api domains & yumpu action urls
	 * @var array config; yumpu api config array
	 */
	
	public $yumpuEndpoints;
	public $config;

	public function __construct() {
        global $config;
        $this->config = $config;
        $this->yumpuEndpoints = $this->config['yumpuEndpoints'];
        $this->log('DEBUG', 'Yumpu Class initialised');
    }
    
    public function __destruct() {
        $this->log('DEBUG', 'Yumpu Class destroyed');
    }

    
/* DOCUMENTS */    
    /** 
     * create a new document from a file
     * more details on: http://developers.yumpu.com/api/document/post-file/
	 * 
     * @param string $data
	 * 
     * @return array|json
     */
    public function postDocumentFile($data) {
        if (!isset($data['title'])) { // if no title provided, generate one from filename
            $data['title'] = basename($data['file'], '.pdf');
        }
		
        $params = array(
            'action' => 'document/post/file',
            'method' => 'POST',
            'data' => $data
        );
       
		if (isset($data['token'])) {
            $params['token'] = $data['token'];
        }
		
        return $this->executeRequest($params);
    }
    
    /** 
     * create a new document from a url
	 * more details on: http://developers.yumpu.com/api/document/post-url/
	 * 
     * @return array|json
     */
    public function postDocumentUrl($data) {
        if (!isset($data['title'])) { // if no title provided, generate one from filename
            $data['title'] = basename($data['file'], '.pdf');
        }
        $params = array(
            'action' => 'document/post/url',
            'method' => 'POST',
            'data' => $data
        );
        if (isset($data['token'])) {
            $params['token'] = $data['token'];
        }
		
        return $this->executeRequest($params);
    }
    
    /** 
     * Get current document progress.
	 * Note: The id you will get when using a create document method (document post file or document post url).
     * more details on: http://developers.yumpu.com/api/document-progress/get/ 
	 * 
     * @param string $progressId
     * @return array|json
     */
    public function getDocumentProgress($progressId) {
        $params = array(
            'action' => 'document/progress',
            'method' => 'GET',
            'data' => array(
                'id' => $progressId
            )
        );
		
		return $this->executeRequest($params);
    }

    /** 
     * get document details
     * more details on: http://developers.yumpu.com/api/document/get-2/
	 * 
     * @param array $data
     * @return array|json
     */
    public function getDocument($data) {
        $params = array(
            'action' => 'document/get',
            'data' => $data
        );
		
        return $this->executeRequest($params);
    }
    
    /** 
     * get list of documents
	 * more details on: http://developers.yumpu.com/api/documents/get/
	 * 
	 * @return array|json
     */
    public function getDocuments($data = array()) {
        $params = array(
            'action' => 'documents/get',
			'data' => $data
        );
		
        return $this->executeRequest($params);
    }
    
	/**
	 * delete the document with id value $id
	 * more details on : http://developers.yumpu.com/api/document/delete/
	 * 
	 * @param int $id
	 * @return array|json
	 */
	public function deleteDocument($id){
		$params = array(
            'action' => 'document/delete',
            'data' => array(
                'id' => $id	
            ),
			'method' => 'POST',
			'customRequest' => 'DELETE'
        );
		
        return $this->executeRequest($params);
	}
    
	
	/** 
     * Update an existing document; 
	 * An example of an update array is $data = array('id' => 'documentId', 'title' => 'myNewDocumentName');
     * more details on : http://developers.yumpu.com/api/document/put/
	 * 
     * @param array $data - array with update document info; id & title are required;
	 * 
     * @return array|json
     */
	public function putDocument($data){
		$params = array(
            'action' => 'document/put',
            'data' => $data,
			'method' => 'POST',
			'customRequest' => 'PUT'
        );
		
        return $this->executeRequest($params);
	}
	
	/* USERS */    
    /** 
     * Create a new user profile
     * more details on: http://developers.yumpu.com/api/user/post/
	 * 
     * @param array $data = array(email, username, password, s.o)
	 * 
     * @return array|json 
     */
    public function postUser($data) {
        $params = array(
            'action' => 'user/post',
            'method' => 'POST',
            'data' => $data
        );
		
        return $this->executeRequest($params);
    }

    /** 
     * Retrieve $token's user profile data
     * more details on: http://developers.yumpu.com/api/user/get/
	 * 
     * @param string
	 * 
     * @return array|json
     */
    public function getUser($data = array()) {
        $params = array(
            'action' => 'user/get',
            'data' => $data,
        );
		
        return $this->executeRequest($params);
    }
    
	/**
	 * update an existing user informations
	 * 
	 * @param array $data - array with user update info; the values that cam be updated are : email, username, password, gender, firstname, lastname, birth_date, address,
	 * zip_code, city, country, description, website, blog, language. 
	 * An example of an update array is $data = array('email' => 'myNewEmail@domain.com', 'username' => 'myNewUsername' , 'password' => 'Password', ....);
	 * more details on: http://developers.yumpu.com/api/user/put/
	 * 
	 * @return array|json
	 */
	
	public function putUser($data) {
        $params = array(
            'action' => 'user/put',
			'method' => 'POST',
            'customRequest' => 'PUT',
            'data' => $data
        );
		
        return $this->executeRequest($params);

	}

/* COLLECTION */ 
	
	/** 
     * create a new collection
	 * An example of an update array is $data = array('name' => 'myCollection');
     * more details on : http://developers.yumpu.com/api/collection/post/
	 * 
     * @param array $data - array with create collection info; name is required;
	 * 
     * @return array|json
     */
	
	public function postCollection($data){
        $params = array(
            'action' => 'collection/post',
            'method' => 'POST',
            'data' => $data
        );
        return $this->executeRequest($params);
	}
	
	/** 
     * update a collection
	 * An example of an update array is $data = array('id' => 'collectionId', 'name' => 'myNewCollectionName');
     * more details on : http://developers.yumpu.com/api/collection/put-2/
	 * 
     * @param array $data - array with update collection info; id & name are required;
	 * 
     * @return array|json
     */
	public function putCollection($data){
        $params = array(
            'action' => 'collection/put',
            'method' => 'POST',
            'customRequest' => 'PUT',
            'data' => $data
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * delete the collection with id value $id
	 * more details on: http://developers.yumpu.com/api/collection/delete-2/
	 * 
	 * @param string $id
	 * @return array|json
	 */
	public function deleteCollection($id){
		$params = array(
            'action' => 'collection/delete',
            'data' => array(
                'id' => $id,	
            ),
			'method' => 'POST',
			'customRequest' => 'DELETE'
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * retrived all datas for the collection with id $id
	 * more details on: http://developers.yumpu.com/api/collection/get-4/
	 * 
	 * @param array $data
	 * 
	 * @return array|json
	 */
	public function getCollection($data){
		$params = array(
            'action' => 'collection/get',
            'data' => $data
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * retrieve all users' collections datas
	 * more details on: http://developers.yumpu.com/api/collections/get-3/
	 * 
	 * @return array|json
	 */
	public function getCollections($data = array()){
		$params = array(
            'action' => 'collections/get',
			'data' => $data
        );
		
        return $this->executeRequest($params);
	}
	
	
/* SECTION */ 
	
	/** 
     * create a new Section
	 * An example of an create array is $data = array('id'=>'oneCollectionId', 'name' => 'mySection');
     * more details on : http://developers.yumpu.com/api/section/post-2/
	 * 
     * @param array $data - array with create collection info; name is required;
	 * 
     * @return array|json
     */
	
	public function postSection($data){	
        $params = array(
            'action' => 'section/post',
            'method' => 'POST',
            'data' => $data
        );
		
        return $this->executeRequest($params);
	}
	
	/** 
     * update a section
	 * An example of an update array is $data = array('id' => 'sectionId', 'name' => 'myNewSectionName', 'description' => 'myNewDescription', 'sorting' => 'create_date_asc');
     * more details on : http://developers.yumpu.com/api/section/put-3/
	 * 
     * @param array $data - array with update collection info; id & name are required;
	 * 
     * @return array|json
     */
	public function putSection($data){
        $params = array(
            'action' => 'section/put',
            'method' => 'POST',
            'customRequest' => 'PUT',
            'data' => $data
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * delete the collection with id value $id
	 * more details on: http://developers.yumpu.com/api/section/delete-3/
	 * 
	 * @param string $id
	 * 
	 * @return array|json
	 */
	public function deleteSection($id){
		$params = array(
            'action' => 'section/delete',
            'data' => array(
                'id' => $id,	
            ),
			'method' => 'POST',
			'customRequest' => 'DELETE'
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * retrived all datas for the collection with $data['id']; reutrn field can be specified in $data['return_fields']
	 * more details on: http://developers.yumpu.com/api/section/get-5/
	 * 
	 * @param string $id
	 * 
	 * @return array|json
	 */
	public function getSection($data){
		$params = array(
            'action' => 'section/get',
            'data' => $data,
        );
		
        return $this->executeRequest($params);
	}
	
	
/* SECTION DOCUMENT*/ 
	
	/** 
     * create a new section document
	 * An example of an create section document array is $data = array('id' => 'mySectionId', 'documents'=> '1,2,3' );
     * more details on :http://developers.yumpu.com/api/section-document/post-3/
	 * 
     * @param array $data - array with create section document info; id & documents are required;
	 * 
     * @return array|json
     */
	
	public function postSectionDocument($data) {
        $params = array(
            'action' => 'sectionDocument/post',
            'method' => 'POST',
            'data' => $data
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * Delete a document in section.
	 * more details on : http://developers.yumpu.com/api/section-document/delete-4/
	 * 
	 * @param array $data
	 * 
	 * @return array|json
	 */
	public function deleteSectionDocument($data) {
        $params = array(
            'action' => 'sectionDocument/delete',
            'method' => 'POST',
			'customRequest' => 'DELETE',
            'data' => $data
        );
		
        return $this->executeRequest($params);
	}
	
	
	/**
	 * retrieve all documents' possible categories
	 * more details on: http://developers.yumpu.com/api/document-categories/get/
	 * 
	 * @return array|json
	 */
	public function getCategories(){
		$params = array(
            'action' => 'categories/get',
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * retrieve all  possible countries
	 * more details on: http://developers.yumpu.com/api/countries/get/
	 * 
	 * @return array|json
	 */
	public function getCountries(){
		$params = array(
            'action' => 'countries/get',
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * retrieve all documents' possible languages
	 * more details on: http://developers.yumpu.com/api/document-languages/get/
	 * 
	 * @return array|json
	 */
	public function getLanguages(){
		$params = array(
            'action' => 'languages/get',
        );
		
        return $this->executeRequest($params);
	}
	
	/**
	 * Search documents taking into consideration different criterias; q param is required;
	 * more details on: http://developers.yumpu.com/api/search/get/
	 * 
	 * @return array|json
	 */
	public function search($data){
		$params = array(
            'action' => 'search/get',
			'data' => $data
        );
		
        return $this->executeRequest($params);
	}

	/** 
     * execute a CURL request to Yumpu
     * 
     * @param array $params. Required keys: token, method
	 * 
     * @return array | json, empty string or NULL
     */
    protected function executeRequest($params) {

        if (isset($params['data']['token']) && !empty($params['data']['token'])) {
            $params['token'] = $params['data']['token'];
			unset($params['data']['token']);
		}else{
			$params['token'] = $this->config['token'];
		}
        if (!isset($params['method']) || empty($params['method'])) {
            $params['method'] = 'GET';
        }

        $url = $this->getActionUrl($params);
		
        if (empty($url)) {
            return FALSE;
        }
		
		if (isset($params['data']) && !empty($params['data']) && $this->config['useCurl']) {
			if (isset($params['data']['file'])){
				$params['data']['file'] = '@'.$params['data']['file'];	
			}
			if (isset($params['data']['page_teaser_image'])){
				$params['data']['page_teaser_image'] = '@'.$params['data']['page_teaser_image'];	
			}
		}
		
		if($this->config['useCurl'] && $this->isCurlInstalled()) {
			$response = $this->doCurl($url, $params);
		}else {
			$response = $this->noCurl($url, $params);
		}
        
        if (is_string($response)) {
			if ($this->config['returnFormat'] != 'json') {
				$response = json_decode($response, TRUE);
			}
        }
        return $response;
    }
	
    /** 
     * generate yumpu endpoint url for an action
     * 
     * @param array $params
	 * 
     * @return FALSE or string
     */
    protected function getActionUrl($params) {
        if (!isset($params['action']) || empty($params['action'])) {
            $this->log('DEBUG', 'Trying to make a request to Yumpu without an action');
            return FALSE;
        }
        if (!isset($this->yumpuEndpoints[$params['action']])) {
            $this->log('DEBUG', 'Trying to make a request to Yumpu with an undefined action');
            return FALSE;
        }
        $url = $this->yumpuEndpoints[$params['action']];
        if (isset($params['data']) && isset($params['method']) && !empty($params['data']) && ($params['method'] === 'GET')) {
            if (strpos($url, '?') === FALSE) {
                $url .= '?' . http_build_query($params['data']);
            } else {
                $url .= '&' . http_build_query($params['data']);
            }
        }
        return $url;
    }
    
	/**
	 * write the request log_file
	 * 
	 * @param string $type
	 * @param string $message
	 */
    protected function log($type, $message) {
        if ($this->config['debug']) {
            $fhandle = fopen($this->config['logFilePath'], 'a+');
            flock($fhandle, LOCK_EX);	
            fwrite($fhandle, $type . ' ' . date("Y-m-d H:i:s") . ' --> INSTANCE_' . getmypid() . ' --> ' . $message . "\n");
            flock($fhandle, LOCK_UN);
            fclose($fhandle);
        }
    }
	
	/**
	 * make the request to yumpu api using curl request
	 * 
	 * @param string $url
	 * @param array $params
	 * 
	 * @return json|boolean
	 */
	private function doCurl($url, $params){	
        $headers = array(
            'X-ACCESS-TOKEN: '.$params['token']
        );
		
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
        if (isset($params['data']) && !empty($params['data'])) {
			if ($params['method'] == 'POST') {
				if (is_array($params['data'])){
					if (!isset($params['data']['file']) && !isset($params['data']['page_teaser_image'])){
						curl_setopt($ch, CURLOPT_POST, true);
						$params['data'] = http_build_query($params['data']);
					}
					curl_setopt($ch, CURLOPT_POSTFIELDS, $params['data']);
				}
			}
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		if (isset($params['customRequest'])){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $params['customRequest']);
		}else{
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $params['method']);
		}
		
        $response = curl_exec($ch);
		
        if ($response === FALSE){
            $this->log("ERROR", "Yumpu response: ".curl_error($ch));
        } else {
            $this->log("DEBUG", "Yumpu response: ".print_r($response, TRUE));
        }
        curl_close($ch);
		
		return $response;
	}
	
	/**
	 * make the request to yumpu api without using curl request
	 * 
	 * @param string $url
	 * @param array $params
	 * 
	 * @return array|boolean
	 */
	private function noCurl($url, $params){
		$parts = parse_url($url);
		$fp = fsockopen($parts['host'], 80);
		
		$method = strtoupper($params['method']);
		if (isset($params['customRequest'])){
			$method = strtoupper($params['customRequest']);
		}
		
		$content = '';
		
		$finalUrl = $parts['path'];
		if (isset($parts['query'])){
			$finalUrl .= '?'.$parts['query'];
		}
			
		if (!isset($params['data']['file']) && !isset($params['data']['page_teaser_image'])) {
			if (isset($params['data']) && is_array($params['data']) && !empty($params['data']) && ($method !== 'GET')) {
				$content = http_build_query($params['data']);
			}
			fwrite($fp, "{$method} {$finalUrl} HTTP/1.1\r\n");
			fwrite($fp, "Host: {$parts['host']}\r\n");
			fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");	
			fwrite($fp, "X-ACCESS-TOKEN: {$params['token']}\r\n");
			fwrite($fp, "Content-Length: ".strlen($content)."\r\n");
			fwrite($fp, "Connection: close\r\n");
			fwrite($fp, "\r\n");
			fwrite($fp, $content);
		} else {	
			srand((double)microtime()*1000000);
			$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

			// Build the header
			$header = "{$method} {$parts['path']} HTTP/1.0\r\n";
			$header .= "Host: {$parts['host']}\r\n";
			$header .= "X-ACCESS-TOKEN: {$params['token']}\r\n";
			$header .= "Content-type: multipart/form-data, boundary=$boundary\r\n";
			// attach post vars
			$data = '';
			foreach($params['data'] AS $index => $value){
				if (($index == 'file') || ($index == 'page_teaser_image')){
					continue;
				}
				$data .="--$boundary\r\n";
				$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
				$data .= "\r\n".$value."\r\n";
				$data .="--$boundary\r\n";
			}
			// and attach the file
			if (isset($params['data']['file'])){
				$file_name = $params['data']['title'].'.pdf'; 
				$content_type = 'application/pdf'; 
			
				$data .= "--$boundary\r\n";
				$content_file = join("", file($params['data']['file']));
				$data .="Content-Disposition: form-data; name=\"file\"; filename=\"$file_name\"\r\n";
				$data .= "Content-Type: $content_type\r\n\r\n";
				$data .= "".$content_file."\r\n";
				$data .="--$boundary--\r\n";
			}
			if (isset($params['data']['page_teaser_image'])){
				$img = explode('/', $params['data']['page_teaser_image']);
				$file_name = $img[count($img)-1]; 
				$imgdata = getimagesize($params['data']['page_teaser_image']);
				$content_type = $imgdata['mime']; 	
				$data .= "--$boundary\r\n";
				$content_file = join("", file($params['data']['page_teaser_image']));
				$data .="Content-Disposition: form-data; name=\"page_teaser_image\"; filename=\"$file_name\"\r\n";
				$data .= "Content-Type: $content_type\r\n\r\n";
				$data .= "".$content_file."\r\n";
				$data .="--$boundary--\r\n";
			}
			
			$header .= "Content-length: " . strlen($data) . "\r\n\r\n";
       
			fputs($fp, $header.$data);
		}
			
		$result = '';
		while (!feof($fp)) {
			$result.= fgets($fp, 1024);
		}
		fclose($fp);
		
		$result = explode('Connection: Close', $result);
		
		if (isset($result[1])){
			return trim($result[1]);
		}
		return FALSE;
	}
	
	/**
	 * check if curl extension is enabled
	 * 
	 * @return boolean
	 */
	private function isCurlInstalled() {
		if  (in_array('curl', get_loaded_extensions())) {
			return true;
		}else {
			if ($this->config['useCurl']){
				$this->log("WARNING", "Your CURL extension in not enabled! Please enable it! The request will be made without using CURL");
			}
		}
		return false;
	}
}
