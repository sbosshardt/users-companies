<?php

/**
 * @file
 * The Simple Controller should be the base class for all uc controllers.
 * 
 * It runs "process" functions (pre-process, model, presenter, and view) to handle
 * the MVCP pattern (model/view/controller/presenter).  Here is a breakdown of
 * each process and what kind of code should be there and what shouldn't.
 * 
 * - Pre-Process: In the pre-process method you can place controller-specific
 *   code (HTTP redirects, etc.).
 * - Model: The model process is responsible for dealing with business logic only.
 * - Presenter: The presenter takes the model data and can transform it in any way
 *   needed for the view.  It's perfectly fine to deal with HTML in this process.
 * - View: In this process, a Blade template is usually rendered view View::make().
 */
namespace uc\Controllers;

abstract class SimpleController extends \BaseController {
  /**
   * This is the data passed into the controller via setInput().
   */
  protected $controllerData;
  
  /**
   * This is the data set in processModel().
   */
  protected $modelData;
  
  /**
   * This is the data set in processPresenter().
   */
  protected $presenterData;
  
  /**
   * Clients should call this to set the initial controller data.
   */
  public function setInput(&$input) {
    $this->controllerData = $input;
  }
  
  /**
   * Returns TRUE if the controller data is not an array or all of its values
   * are empty.
   * 
   * @return
   *   TRUE if the controller data is considered empty.
   */
  protected function isControllerDataEmpty() {
    if (!is_array($this->controllerData)) {
      return TRUE;
    }
    
    foreach ($this->controllerData as $value) {
      if (!empty($value)) {
        return FALSE;
      }
    }
    
    return TRUE;
  }
  
  /**
   * Processes the steps in this order (with conditions):
   * 
   * 1) preProcess() - If the return value of this method is not identical to NULL,
   *    then no other steps are called.
   * 2) processModel()
   * 3) processPresenter()
   * 4) processView() - The return value of this call is returned.
   * 
   * @return
   *   The result of preProcess() or processView() (whichever comes first).
   */
  public function process() {
    $ret = $this->preProcess();
    if ($ret !== NULL) {
      return $ret;
    }
    
    $this->processModel();
    $this->processPresenter();
    return $this->processView();
  }

  /**
   * Override this method to provide a pre-processing for this controller.
   * 
   * If you return a value that's not identical to NULL, this value will be returned by process().
   * 
   * @return
   *   NULL if the processing should continue to the next step.
   *   Non-NULL if the processing is done and should return to the client (this
   *   data will be returned).
   */
  abstract function preProcess();
  
  /**
   * Override this method to provide the model processing.
   * 
   * Your implementation should only perform business logic and can set the data
   * in $modelData. 
   */
  abstract function processModel();
  
  /**
   * Override this method to provide a presentational view of the model's data.
   * 
   * Your implementation is allowed to deal with HTML here.  You can set the data
   * in $presenterData.
   */
  abstract function processPresenter();
  
  /**
   * Override this method to return the output that the end-user will receive.
   * 
   * @return
   *   The view data that will be rendered to the end-user.
   */
  abstract function processView();
}
