<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('login');
}*/

use Illuminate\Support\Facades\Artisan;

Route::get('/', ['as' => 'login', 'uses' => 'SessionController@index']);
//Route::get('/login', 'SessionController@index');
Route::post('/login', 'SessionController@create');
Route::get('/logout', 'SessionController@destroy');

//Alterar Password
Route::get('/password', 'UserController@indexPassword');
Route::post('/changePassword', 'UserController@alterarSenha');

Route::group(['middleware' => ['RedirectIfAuthenticated']], function () {
//    Route::resource('/home', 'HomeController');

    #PESQUISA POR CEP
    Route::get('/cep/cep', 'CepController@findCep');
    Route::get('/cep/cidades', 'CepController@findCidades');

    #USER
    Route::resource('/user', 'UserController');
//    Route::resource('/user_grupo', 'UserGrupoController');
    Route::post('/user/activeDisabled', 'UserController@activeDisabled');


    #PESSOAS
    Route::get('/person/list-person', 'PessoaController@listPessoa');
    Route::resource('/person', 'PersonController');
    Route::post('/person/activeDisabled', 'PersonController@activeDisabled');
    Route::get('/person/pdf', 'PersonController@pdf');
    Route::get('/person/csv', 'PersonController@csv');

    #HISTORICO
    Route::resource('/history', 'HistoryController');

    #SERVICE
    Route::post('/service/activeDisabled', 'ServiceController@activeDisabled');
    Route::get('/service/contract_service', 'ContractServiceController@findValue');
    Route::resource('/service', 'ServiceController');

    #TICKET
    Route::resource('/ticket', 'TicketController');
    Route::post('/ticket/activeDisabled', 'TicketController@activeDisabled');

    #   BANK_ACCOUNT
    Route::resource('/bank_account', 'BankAccountController');
    Route::post('/bank_account/activeDisabled', 'BankAccountController@activeDisabled');

    # PAYMENT_TYPE
    Route::resource('/payment_type', 'PaymentTypeController');
    Route::post('/payment_type/activeDisabled', 'PaymentTypeController@activeDisabled');

    #IMEI
    Route::resource('/contract/contract_imei', 'ImeiController');

    #CAR
    Route::post('/contract/contract_car', 'CarController@store');

    #CONTRACT_SERVICE
    Route::post('/contract/contract_service', 'ContractServiceController@store');

    #CONTRACT
    Route::post('/contract/activeDisabled', 'ContractController@activeDisabled');
    Route::resource('/contract', 'ContractController');
    Route::get('/contract/contract_car/{id}/save', 'CarController@index');
    Route::resource('/contract/contract_imei/{id}/save', 'ImeiController');
    Route::resource('/contract/contract_service/{id}/save', 'ContractServiceController');

    #   CONTRACT SERVICE
    Route::get('/contract_service/', 'ContractServiceController@getValueOfService');

    //adicionar a permissão da rota no /app/Http/Middleware/RedirectIfAuthenticated
});


//rota para executar as migrations - o servidor não suporta comandos ssh
Route::get('/run-migrations', function () {
    return Artisan::call('migrate');
});