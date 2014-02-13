<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace uc\Controllers;

use uc\Controllers;
use uc\Models;
use uc\Presenters;
use uc\Views;

class UserController extends SimpleController
{
    public function preProcess() {
        // nothing
    }
    public function processModel() {
        
    }
    public function processPresenter() {
        
    }
    public function processView() {
        return \View::make('user')->with('response', $this->presenterData);
    }
}