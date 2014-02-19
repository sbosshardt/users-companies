<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Refactored back to simpler directories - no longer needed
//namespace uc\Controllers;

class PrimaryController extends \BaseController
{
    public function getIndex()
    {
        $subController = new \HomeController();
        $view = $subController->showWelcome();
        echo "Index!";
        return $view;
    }
/*
    public function getUser($parameters = array())
    {

    }
    public function putUser($parameters = array())
    {
        
    }
    public function postUser($parameters = array())
    {
        
    }
    public function deleteUser($parameters = array())
    {
        
    }
*/   
    public function missingMethod($parameters = array())
    {
        $testFilename = "";
        $slashNeeded = false;
        foreach ($parameters as $param)
        {
            $testFilename .= ($slashNeeded == true) ? "/" : "";
            $slashNeeded = true;
            $testFilename .= $param;
        }
        //echo "Filename is $testFilename.  Path is: ";
        $testFile = getcwd() . $testFilename;
        if (file_exists($testFile) === true)
        {
            return file_get_contents($testFile);
        }
        //echo $testFile;
        
        //echo " CWD: " . getcwd();
        
        
        $subController = new \HomeController();
        echo "Error: Missing Method.  Tried to load: " . print_r($parameters);
        $view = $subController->showWelcome();
        return $view;
    }
}

