<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return shell_exec('php artisan cache:clear');
});

$router->group(['prefix' => 'api'], function () use ($router) {
  $router->get('offers',  ['uses' => 'OfferController@showAlloffers']);

  $router->get('recipients',  ['uses' => 'RecipientController@showAllRecipients']);
    
  $router->get('vouchercodes',  ['uses' => 'VoucherCodeController@showAssignedVoucherCodes']);
  
  $router->post('vouchercodes/generate',  ['uses' => 'VoucherCodeController@generateVoucherCode']);

  $router->post('vouchercodes/redeem',  ['uses' => 'VoucherCodeController@redeemVoucherCode']);
});