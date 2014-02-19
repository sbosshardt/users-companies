<?php

/**
 * @file
 * A presenter class formats a model's response before it's handed off to a view.
 * 
 * Normally, the view handles some formatting of the data but ideally a view
 * should just render stuff without much logic or formatting code.
 * 
 * Presenters are allowed to mix-in HTML.  The reason for this is three-fold:
 * 
 * 1) The presenter might have to do some heavy massaging of the data and gives
 * a way for the template designer not to have to worry about dealing with this.
 * 
 * 2) Blade templates are just PHP code with some special syntax.  Having the
 * presenter handle some HTML processing is not that big of a deal since that
 * code would have been moved into the template anyway.  Splitting the
 * presentation from the view gives us another layer of separation
 * that may be beneficial in some cases.
 * 
 * 2) The presentation PHP code can be easily re-used compared to having the code
 * in the template.
 */

abstract class BasePresenter {
  /**
   * This is the original data offered to the presenter.
   * This value will not change.
   */
  protected $dataIn = NULL;
  
  /**
   * This is the presented data that will be sent into the view for output.
   * For performance reasons, this may just be a reference to $dataIn.
   */
  protected $dataOut = NULL;
  
  /**
   * Sets the data the presenter will use.
   *
   * @param $data
   *   Data specific to the child presenter that will be formatted.
   */
  public function setData(&$data) {
    $this->dataIn = $data;
  }
  
  /**
   * Override this method to "present" the set data into its final form.
   *
   * @return
   *   The final, presented data.
   */
  abstract public function present();
}
?>
