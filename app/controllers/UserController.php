<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Refactored back to simpler directories - no longer needed
/*
namespace uc\Controllers;

use uc\Controllers;
use uc\Models;
use uc\Presenters;
use uc\Views;
*/

class UserController extends SimpleController
{
    /**
     * This is an instance of the UserService class
     */
    private $service;
    
    public function preProcess() {
        // if our URL ends with /user, then the default mode of userIndex is good
        // if it doesn't, we set mode to user (as in, viewing/editing a particular user)
        $URIPieces = explode("/", $_SERVER['REQUEST_URI']);
        if ($URIPieces[sizeof($URIPieces)-1] !== "user")
        {
            $this->controllerData['uid'] = $URIPieces[sizeof($URIPieces)-1];  
        }
        else
        {
            $this->controllerData['uid'] = NULL;
        }
    }
    
    public function processModel() {
        $this->service = new UserService();
        $this->service->setParams(
                array( 'uid' => $this->controllerData['uid'], )
                );
        // not sure why we are executing this conditional
        if (!empty($this->controllerData['uid']))
        {
            $this->service->setMode("user");
            $this->modelData = $this->service->process();
        }
    }
    
    public function processPresenter() {
        // test data...

        $presenter = new UserPresenter();
        
        // process the service, get the "formattedResponse"
        $response = $this->service->process();
        
        $presenter->setData($response);
        $this->presenterData = $presenter->present();
    }
    
    /*
    public function processPresenter() {
        
    }
    */
    
    public function processView() {
        
        $view = NULL;
        
        if ($this->service->getMode() == "userIndex")
        {
            $view = View::make('userIndex')->with('response', $this->presenterData);
        }
        else
        {
            $view = View::make('user')->with('stuff', array( 'uid' => $this->controllerData['uid'] , 'response' => $this->presenterData ) );
        }
        
        return $view;
    }
    
    // implement all the RESTful CRUD routes
    /**
     * GET /user
     */
    public function index()
    {
        $this->controllerData['mode'] = "index";
        $view = $this->process();
        return $view;
    }
    
    /**
     * GET /user/create
     */
    public function create()
    {
        // TODO: Implement form to create new user records
        $this->controllerData['mode'] = "create";
    }
    
    /**
     * POST /user
     */
    public function store()
    {
        // TODO: Implement creating new user records
        $this->controllerData['mode'] = "store";
    }
    
    /**
     * GET /user/{uid}
     */
    public function show($uid)
    {       
        // Show the record for the given uid
        $this->controllerData['mode'] = "show";
        $view = $this->process();
        return $view;
    }
    
    /**
     * GET /user/{uid}/edit
     */
    public function edit($uid)
    {
        // TODO: Implement form to edit user's records
        $this->controllerData['mode'] = "edit";
    }
    
    /**
     * PUT or PATCH /user/{uid}
     */
    public function update($uid)
    {
        // TODO: Process editing form to update user's records
        $this->controllerData['mode'] = "update";
    }
    
    /**
     * DELETE /user/{uid}
     */
    public function destroy($uid)
    {
        // TODO: Implement deleting a user's record
        $this->controllerData['mode'] = "destroy";
    }
}