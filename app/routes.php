<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
Route::get('/', function()
{
    $anvil = new uc\AnvilHeavy;
    print_r($anvil);
    echo $anvil->drop();
    
	return View::make('hello');
});
*/


/**
 * This context root is the base path for all apps components.  It should be 
 * added to all routes/URLs.
 */


define('ROUTES_UC_CONTEXT_ROOT', '/');

//Route::controller(ROUTES_UC_CONTEXT_ROOT . "", 'PrimaryController');
Route::resource(ROUTES_UC_CONTEXT_ROOT . "user", 'UserController');

Route::controller("", "PrimaryController");