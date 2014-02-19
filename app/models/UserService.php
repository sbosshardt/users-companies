<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserService extends Service {
    
    /**
     * Set to userIndex if we are listing all users' uids
     * Set to user if listing a particular user's details
     * @var mode
     */
    protected $mode = "userIndex";
    
    
    public function setMode($mode)
    {
        $this->mode = $mode;
    }
    
    public function getMode()
    {
        return $this->mode;
    }
    
    private static $ATTRIBUTE_MAP = array(
        'uid',
    );
    
    /**
     * 
     * Sets the service parameters specified in $params
     * 
     * @param type $params
     */
    public function setParams($params) {
        parent::setParams($params);
    }
    
    /**
     * Returns custom parameters needed to run the user request
     * 
     * The CURL parameters we set are the URL to the service
     * 
     * @return
     *  CURL parameters needed to run the user request.
     */
    protected function getCustomCurlParams() {
        $urlSuffix = Config::get('uc.userIndex.path');
        if ($this->mode == "user") // as opposed to userIndex
        {
            $urlSuffix = sprintf(Config::get('uc.user.path'), $this->params['uid']);
        }
        
        $curlParams = array(
            CURLOPT_URL => sprintf('%s%s', Config::get('uc.global.baseProtoAndDomain'), $urlSuffix),
        );
        
        return $curlParams;
    }
    
    /**
     * Parses the XML data returned by phprestsql.sourceforge.net into a useable array.
     * 
     * NULL will be set if the HTTP request failed
     * An empty array will be set when there were 0 users found.
     * Otherwise, an index-based array is set with keys:
     * 
     * - uid: the uid of the user.
     */
    protected function parseResponse() {
        $this->responseFormatted = NULL;
        if ($this->curlInfo['http_code'] != 200){
            $this->errorMessage = "CURL request failed with http code: {$this->curlInfo['http_code']}";
            return;
        }
        
        $dom = new DOMDocument();
        $loadRes = $dom->loadXML($this->response);
        if (!$loadRes) {
            $this->errorMessage = "The returned XML could not be properly parsed.  XML Dump: {$this->response}";
            return;
        }
        
        //var_dump($dom);
        
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query("//row");
        $this->responseFormatted = array();
        if (!is_null($elements))
        {
            // determine if we are showing the listing of all the uids or we are
            // showing a particular user's listing
            if ($this->mode == "userIndex")
            {
                foreach ($elements as $element)
                {
                    array_push($this->responseFormatted,
                            array( "uid" => $element->nodeValue) );
                }
            }
            else
            {
                foreach ($elements as $element)
                {
                    $nodes = $element->childNodes;
                    $responseElement = array();
                    foreach ($nodes as $node)
                    {
                        $responseElement[$node->nodeName] = $node->nodeValue;
                    }
                    array_push($this->responseFormatted, $responseElement);
                }
            }
        }
    }
}