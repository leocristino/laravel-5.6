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
Route::get('/', ['as' => 'login', 'uses' => 'SessionController@index']);
//Route::get('/login', 'SessionController@index');
Route::post('/login', 'SessionController@create');
Route::get('/logout', 'SessionController@destroy');

//Alterar Password
Route::get('/password', 'UserController@indexPassword');
Route::post('/changePassword', 'UserController@alterarSenha');

Route::group(['middleware' => ['RedirectIfAuthenticated']], function () {
//    Route::resource('/home', 'HomeController');

    Route::get('/cep/cep', 'CepController@findCep');
    Route::get('/cep/cidades', 'CepController@findCidades');

    Route::resource('/user', 'UserController');
    Route::resource('/user_grupo', 'UserGrupoController');

    Route::get('/pessoa/list-pessoa', 'PessoaController@listPessoa');
    Route::resource('/person', 'PersonController');

    //adicionar a permissão da rota no /app/Http/Middleware/RedirectIfAuthenticated
});