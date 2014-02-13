<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace uc\Controllers;

class PrimaryController extends \BaseController
{
    public function getIndex()
    {
        $subController = new \HomeController();
        echo "Helloooo world!!!";
        $view = $subController->showWelcome();
        return $view;
    }
    public function getUser()
    {
        $subController = new UserController();
        $view = "";
        return $view;
    }
    public function missingMethod($parameters = array())
    {
        $subController = new \HomeController();
        echo "Error: Missing Method.  Tried to load: " . print_r($parameters);
        $view = $subController->showWelcome();
        return $view;
    }
}

