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
    Route::post('/person/activeDisabled', 'PersonController@activeDisabled');
    Route::get('/person/pdf', 'PersonController@pdf');
    Route::get('/person/csv', 'PersonController@csv');
    Route::resource('/person', 'PersonController');

    #HISTORICO
    Route::get('/history/pdf', 'HistoryController@pdf');
    Route::get('/history/csv', 'HistoryController@csv');
    Route::resource('/history', 'HistoryController');

    #SERVICE
    Route::post('/service/activeDisabled', 'ServiceController@activeDisabled');
    Route::get('/service/contract_service', 'ContractServiceController@findValue');
    Route::resource('/service', 'ServiceController');

    #TICKET
    Route::post('/ticket/activeDisabled', 'TicketController@activeDisabled');
    Route::resource('/ticket', 'TicketController');

    #   BANK_ACCOUNT
    Route::post('/bank_account/activeDisabled', 'BankAccountController@activeDisabled');
    Route::resource('/bank_account', 'BankAccountController');

    # PAYMENT_TYPE
    Route::post('/payment_type/activeDisabled', 'PaymentTypeController@activeDisabled');
    Route::resource('/payment_type', 'PaymentTypeController');

    #IMEI
    Route::resource('/contract/contract_imei', 'ImeiController');

    #CAR
    Route::post('/contract/contract_car', 'CarController@store');

    #CONTRACT_SERVICE
    Route::post('/contract/contract_service', 'ContractServiceController@store');

    #CONTRACT
    Route::get('/contract/pdf', 'ContractController@pdf');
    Route::get('/contract/csv', 'ContractController@csv');
    Route::post('/contract/activeDisabled', 'ContractController@activeDisabled');
    Route::get('/contract/contract_car/{id}/save', 'CarController@index');
    Route::resource('/contract', 'ContractController');
    Route::resource('/contract/contract_imei/{id}/save', 'ImeiController');
    Route::resource('/contract/contract_service/{id}/save', 'ContractServiceController');

    #   CONTRACT SERVICE
    Route::get('/contract_service/', 'ContractServiceController@getValueOfService');

    #payable_receivable
    Route::get('/payable_receivable/pdf', 'PayableReceivableController@pdf');
    Route::get('/payable_receivable/csv', 'PayableReceivableController@csv');
    Route::post('/payable_receivable/delete', 'PayableReceivableController@delete');
    Route::resource('/payable_receivable', 'PayableReceivableController');

    #BILLING
    Route::resource('/billing', 'BillingController');

    #   INVOICES NFS
    Route::get('/invoices_nfs/', 'InvoicesNFSController@index');
    Route::get('/invoices_nfs/{id}/{id_bank_account}/bill', 'InvoicesNFSController@bill');
//    Route::post('/invoices_nfs/{id}/nfs', 'InvoicesNFSController@nfs');

    //adicionar a permissão da rota no /app/Http/Middleware/RedirectIfAuthenticated
});


Route::get('/bill/download/{id}', 'BillController@index');


//rota para executar as migrations - o servidor não suporta comandos ssh
Route::get('/run-migrations', function () {
    return Artisan::call('migrate');
});