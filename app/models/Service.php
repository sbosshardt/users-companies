<?php

/**
 * @file
 * EtrakApiService is the abstract base class for all API service calls to eTrak.
 * 
 * For specific API calls, override the methods as necessary.
 */

abstract class Service {
  /**
   * These CURL parameters are applied to every service request.  Right now,
   * there is no reason why these need to change, so they have been labelled
   * as "static" parameters.
   */
  private static $STATIC_PARAMS = array(
    CURLOPT_FOLLOWLOCATION => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_SSL_VERIFYPEER => FALSE,
    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
  );
  
  /**
     * Set to userIndex if we are listing all users' uids
     * Set to user if listing a particular user's details
   * 
   * name of resource (e.g. index, create, store, show, edit, update, destroy)
   * 
     * @var mode
     */
    protected $mode;
    
    public function setMode($mode)
    {
        $this->mode = $mode;
    }
    
    public function getMode()
    {
        return $this->mode;
    }
  
  /**
   * This is an array of default CURL params that can be overwritten in getCustomCurlParams().
   * 
   * @see Configuration for etrak.global.defaultCurlParams.
   */
  private $curlDefaultParams;
  
  /**
   * These were the CURL parameters sent to eTrak (default + custom).
   */
  protected $curlParams;
  
  /**
   *  This is the result of the curl_getinfo() call after a request has ran.
   */
  protected $curlInfo;
  
  /**
   * These are custom key-value pair parameters specific to the child class.
   */
  protected $params;
  
  /**
   * This is the raw response string for eTrak.  This will be NULL when
   * the request has failed.
   */
  protected $response;
  
  /**
   * This is the formatted response, which is specific to each child class.
   */
  protected $responseFormatted;
  
  /**
   * This is a custom error message field that is meant for programmer debugging.
   */
  protected $errorMessage;
  
  /**
   * Sets up default CURL parameters that are applicable to all service calls.
   */
  public function __construct() {
    $this->curlDefaultParams = \Config::get('uc.global.defaultCurlParams');
  }
  
  /**
   * Sets the service parameters needed to run the request.
   * 
   * Each child service class will have different parameter needs.  
   * 
   * @param $params
   *   Child service parameters.
   * 
   * @see setParams() of child class.
   */
  public function setParams($params) {
    $this->params = $params;
  }
  
  /**
   * Returns the error message set by the child service.
   * 
   * @return
   *   The error message set by the child service.
   */
  public function getErrorMessage() {
    return $this->errorMessage;
  }
  
  /**
   * Calls the getCustomCurlParams() method of the child class to retrieve
   * any custom CURL params.  The default parameters are appended to this
   * array to get the union of both.
   */
  private final function setCurlParams() {
    $custom = $this->getCustomCurlParams();
    $this->curlParams = $custom + $this->curlDefaultParams;
  }
  
  /**
   * Runs the request, parses the response and returns the response formatted.
   * 
   * @return
   *   A formatted response specific to the child class implementation.
   * 
   * @see $curlDefaults
   */
  public final function process() {
    $this->setCurlParams();
    $this->runRequest();
    $this->parseResponse();
    
    return $this->responseFormatted;
  }
    
  /**
   * Runs a generic request to eTrak and stores the $response and $curlInfo
   * internally.
   */
  protected function runRequest() {
    $ch = curl_init($this->curlParams[CURLOPT_URL]);
    
    $params = self::$STATIC_PARAMS + $this->curlParams;
    curl_setopt_array($ch, $params);
    
    $this->response = curl_exec($ch);
    $this->curlInfo = curl_getinfo($ch);
    curl_close($ch);
  }
  
  /**
   * Recursively parses the <entry> nodes to fill out an associatve array
   * that is more descriptive based on array maps.
   * 
   * @param $entry
   *   A DOMNode element to start parsing from.
   * @param $responseFormatted
   *   Reference to the associative array to fill out.
   * @param $map
   *   An array of labels that represent the  key label to use when setting keys
   *   in $responseFormatted.  For instance, if $map is set to: 'name', 'email', 'age',
   *   the first three <entry> elements will have their values set to the value
   *   of that element with the key being the 0-based index reference in $map.
   * @param $mapArrays
   *   An array of keys that themselves are present in $map and having a value
   *   which is a similar array to $map.
   */
  protected function parseEntries(\DOMnode $entry, &$responseFormatted, &$map, $mapArrays) {
    if ($entry == NULL) {
      return;
    }
    
    while ($entry) {
      if ($entry->nodeName == 'entry' && $entry->nodeType == XML_ELEMENT_NODE) {
        $attribute_index = count($responseFormatted);
        $key = $map[$attribute_index];
        
        if (array_key_exists($key, $mapArrays) && $entry->childNodes->length > 0) {
          $responseFormatted[$key] = array();
          $this->parseEntries($entry->firstChild, $responseFormatted[$key], $mapArrays[$key], $mapArrays);
        }
        else {
          $value = $entry->nodeValue;
          $responseFormatted[$key] = $value;
        }
      }

      $entry = $entry->nextSibling;
    }
  }
  
  /**
   * Abstract method to retrieve custom CURL parameters from the child class.
   * 
   * @see Configuration for etrak.global.defaultCurlParams.
   */
  abstract protected function getCustomCurlParams();
  
  /**
   * Abstract method to parse the raw response from eTrak.
   */
  abstract protected function parseResponse();
}
?>
