<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserService extends Service {
    
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
        $HTTPMethod = "GET";
        
        switch ($this->mode)
        {
            case "index":
            case "store":
                $urlSuffix = Config::get('uc.user-index.path');
                break;
            case "edit":
            case "show":
            case "update":
            case "destroy":
                $urlSuffix = sprintf(Config::get('uc.user-uid.path'), $this->params['uid']);
                break;
            case "create":
                "ERROR: getCustomCurlParams should not be called while service is in 'create' mode.  ";
            default:
                echo "ERROR: mode is set to an unknown or invalid value in UserService.";
                die();
                break;
        }
        
        if ($this->mode == "store")
        {
            $HTTPMethod = "POST";
        }
        else if ($this->mode == "update")
        {
            $HTTPMethod = "PUT";
        }
        else if ($this->mode == "destroy")
        {
            $HTTPMethod = "DELETE";
        }
        
        $curlParams = array(
            CURLOPT_URL => sprintf('%s%s', Config::get('uc.global.baseProtoAndDomain'), $urlSuffix),
            CURLOPT_CUSTOMREQUEST => $HTTPMethod,
            //CURLOPT_HTTPHEADER => array("X-HTTP-Method-Override: $HTTPMethod"),
            CURLOPT_HTTPHEADER => array("Content-Type: application/json"),
        );
        
        if ( ($this->mode == "store") || ($this->mode == "update") )
        {
            $DataToSubmit = Input::except('_method', '_token');
            $POSTFields = http_build_query($DataToSubmit);
            $TestPostFields = "";
            foreach ($DataToSubmit as $Key => $Value)
            {
                $Key = urlencode($Key);
                $Value = str_replace("%40", "@", $Value);
                //$Value = urlencode($Value);
                // don't use \r\n, just \n.
                // this service does not seem to support post string with ampersands
                $TestPostFields .= "$Key=$Value\n";
            }
            //$curlParams = $curlParams + array(CURLOPT_POST => count($DataToSubmit), CURLOPT_POSTFIELDS => $DataToSubmit);
            //$curlParams = $curlParams + array(CURLOPT_POSTFIELDS => $POSTFields);
            $curlParams = $curlParams + array(CURLOPT_POSTFIELDS => $TestPostFields);
        }
        
        //var_dump($curlParams);
        
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
        
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query("//row");
        $this->responseFormatted = array();
        if (!is_null($elements))
        {
            // determine if we are showing the listing of all the uids or we are
            // showing a particular user's listing
            if ($this->mode == "index")
            {
                $uidlist = array();
                foreach ($elements as $element)
                {
                    array_push($uidlist,
                            array( "uid" => $element->nodeValue) );
                }
                $this->responseFormatted["uidlist"] = $uidlist;
            }
            else if ( ($this->mode == "show") || ($this->mode == "edit") )
            {
                $element = $elements->item(0);
                $nodes = $element->childNodes;
                $userdata = array();
                foreach ($nodes as $node)
                {
                    $userdata[$node->nodeName] = $node->nodeValue;
                }
                $this->responseFormatted['userdata'] = $userdata;
            }
        }
        else
        {
            echo "NOTICE: NO KNOWN XML ELEMENTS WERE RETURNED FROM THIS METHOD";
        }
    }
}