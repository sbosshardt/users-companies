<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserPresenter extends BasePresenter
{
    
    public function present() {
        // do nothing
        $this->dataOut = &$this->dataIn;
        
        return $this->dataOut;
    }
    
}