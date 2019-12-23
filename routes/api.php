<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List Formulaire
Route::get('formulaire', 'FormulaireController@index');

// List single Formulaire
Route::get('formulaire/{id}', 'FormulaireController@show');

// Create new Formulaire
Route::post('formulaire', 'FormulaireController@store');

// Update Formulaire
Route::put('formulaire', 'FormulaireController@store');

// Delete Formulaire
Route::delete('formulaire/{id}', 'FormulaireController@destroy');


