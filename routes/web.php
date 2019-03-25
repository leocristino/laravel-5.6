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
    Route::resource('/imei', 'ImeiController');
    Route::post('/imei/activeDisabled', 'ImeiController@activeDisabled');

    #CAR
    Route::resource('/car', 'CarController');
    Route::post('/car/activeDisabled', 'CarController@activeDisabled');

    //adicionar a permissão da rota no /app/Http/Middleware/RedirectIfAuthenticated
});


//rota para executar as migrations - o servidor não suporta comandos ssh
Route::get('/run-migrations', function () {
    return Artisan::call('migrate');
});