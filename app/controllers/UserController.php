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
    
    /**
     *
     * @var if there is a supplied user id
     */
    private $uid;
    
    /**
     *
     * @var name of resource (e.g. index, create, store, show, edit, update, destroy)
     */
    private $resourceName;
    
    public function preProcess() {
        $this->service = new UserService();
        // if our URL ends with /user, then the default mode of userIndex is good
        // if it doesn't, we set mode to user (as in, viewing/editing a particular user)
        
        // we probably don't need this anymore, since switching to resource controller..
        /*
        $URIPieces = explode("/", $_SERVER['REQUEST_URI']);
        if ($URIPieces[sizeof($URIPieces)-1] !== "user")
        {
            $this->controllerData['uid'] = $URIPieces[sizeof($URIPieces)-1];  
        }
        else
        {
            $this->controllerData['uid'] = NULL;
        }*/
    }
    
    public function processModel() {
        /*
        $this->service->setParams(
                array( 'uid' => $this->controllerData['uid'], )
                );
         */
        $this->service->setParams( array('uid' => $this->uid, ) );
        $this->service->setMode($this->resourceName);
        
        // not sure why we are executing this conditional
        /*
        if (!empty($this->controllerData['uid']))
        {
            $this->service->setMode("user");
            $this->modelData = $this->service->process();
        }
         */
        /*
        if (!empty($this->uid))
        {
            $this->service->setMode("user");
            //$this->modelData = $this->service->process();
        }
         */
    }
    
    public function processPresenter() {
        // test data...

        $presenter = new UserPresenter();
        
        // process the service, get the "formattedResponse"
        if ($this->resourceName !== "create")
        {
            $response = $this->service->process();
        }
        
        $response['currentResourceName'] = $this->resourceName;
        switch ($this->resourceName)
        {
            case "edit":
                $response['routeNameForForm'] = "update";
                break;
            case "create":
                $response['routeNameForForm'] = "store";
                break;
            default:
                $response['routeNameForForm'] = "UNKNOWN ROUTE NAME FOR FORM";
                break;
        }
        $response['uid'] = @$this->uid;
        
        $presenter->setData($response);
        $this->presenterData = $presenter->present();
    }
    
    
    public function processView() {
        
        $view = NULL;
        // index, create, store, show, edit, update, destroy
        switch ($this->resourceName)
        {
            case "index":
                $view = View::make('userIndex')->with('response', $this->presenterData);
                break;
            case "create":
                $view = View::make('userform')->with('response', $this->presenterData);
                break;
            case "store":
                //$view = View::make('userIndex')->with('response', $this->presenterData);
                $view = $this->show(Input::get('uid'));
                break;
            case "show":
                $view = View::make('user')->with('response', $this->presenterData);
                break;
            case "edit":
                $view = View::make('userform')->with('response', $this->presenterData);
                break;
            case "update":
                $view = $this->show($this->uid);
                //$view = View::make('user')->with('response', $this->presenterData);
                break;
            case "destroy":
                $view = View::make('userIndex')->with('response', $this->presenterData);
                break;
            default:
                echo "ERROR: UNKNOWN RESOURCE NAME '{$this->resourceName}'";
                break;
        }
        
        return $view;
    }
    
    // implement all the RESTful CRUD routes
    /**
     * GET /user
     */
    public function index()
    {
        $this->resourceName = "index";
        $view = $this->process();
        //var_dump($view);
        return $view;
    }
    
    /**
     * GET /user/create
     */
    public function create()
    {
        // TODO: Implement form to create new user records
        $this->resourceName = "create";
        $view = $this->process();
        return $view;
    }
    
    /**
     * POST /user
     */
    public function store()
    {
        // TODO: Implement creating new user records
        $this->resourceName = "store";
        $view = $this->process();
        return $view;
    }
    
    /**
     * GET /user/{uid}
     */
    public function show($uid)
    {       
        // Show the record for the given uid
        $this->resourceName = "show";
        $this->uid = $uid;
        $view = $this->process();
        return $view;
    }
    
    /**
     * GET /user/{uid}/edit
     */
    public function edit($uid)
    {
        // TODO: Implement form to edit user's records
        $this->resourceName = "edit";
        $this->uid = $uid;
        $view = $this->process();
        return $view;
    }
    
    /**
     * PUT or PATCH /user/{uid}
     */
    public function update($uid)
    {
        // TODO: Process editing form to update user's records
        $this->resourceName = "update";
        $this->uid = $uid;
        $view = $this->process();
        return $view;
    }
    
    /**
     * DELETE /user/{uid}
     */
    public function destroy($uid)
    {
        // TODO: Implement deleting a user's record
        $this->resourceName = "destroy";
        $this->uid = $uid;
        $view = $this->process();
        return $view;
    }
}