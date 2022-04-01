<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'App\Http\Controllers', 'as' => 'api.'], function () {

    //Modules API's
    Route::get('getModule', 'ModulesApiController@getModule');
    Route::post('storeModule', 'ModulesApiController@storeModule');
    Route::post('getModuleById', 'ModulesApiController@getModuleById');
    Route::get('parentChildModule', 'ModulesApiController@parentChildModule');
    Route::post('deleteModule', 'ModulesApiController@deleteModule');

    //Test case API's
    Route::get('getTestCases', 'TestCasesApiController@getTestCases');
    Route::post('storeTestCases', 'TestCasesApiController@storeTestCases');
    Route::post('fetch_testcases_by_id', 'TestCasesApiController@getTestCaseById');
    Route::post('delete_testcases', 'TestCasesApiController@deleteTestCases');
    Route::post('fileupload', 'TestCasesApiController@fileUpload');

});