<?php

return array(
  /**
   * Global configuration for eTrak's APIs.
   */
  'global' => array(
    /**
     * This is the base protocol and domain used for all service requests.
     */
    'baseProtoAndDomain' => 'http://phprestsql.sourceforge.net',
    /**
     * These are the default CURL parameters used unless they are overwritten
     * by the child Service config below.
     */
    'defaultCurlParams' => array(
      /**
       * Default HTTP verb is 'GET'.
       */
      CURLOPT_CUSTOMREQUEST => 'GET',
      /**
       * Username:password for all the services is the same.
       */
      CURLOPT_USERPWD => 'p126371rw:demo',
      /**
       * Connection timeout in seconds.
       */
      CURLOPT_CONNECTTIMEOUT => 30,
      /**
       * Read timeout in seconds.
       */
      CURLOPT_TIMEOUT => 90,
    ),
  ),
  /**
   * Configuration variables for users-companies service.
   */
  'userIndex' => array(
    /**
     * Service path to retrieve user information from uid.
     */
    'path' => '/tutorial/user.xml',
  ),
  'companyIndex' => array(
    /**
     * Service path to retrieve user information from uid.
     */
    'path' => '/tutorial/company.xml',
  ),
  'user' => array(
    /**
     * Service path to retrieve user information from uid.
     */
    'path' => '/tutorial/user/%s.xml',
  ),
  'company' => array(
    /**
     * Service path to retrieve company information from uid
     */
    'path' => '/tutorial/company/%s.xml',
  ),
);
?>
