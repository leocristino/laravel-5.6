<?php

namespace App\Http\Middleware;

use App\Models\Permissao;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {

            if($request->ajax()){
                return response()->json(['result' => 'false', 'msg' => 'Tempo da sessão expirou, faça login novamente.', 'redirect' => '/']);
            }

            Session::put('last_url', $request->getRequestUri());
            return redirect('/');
        }

        $path = explode("/", strtolower($request->getPathInfo()));
        //$path[0] = "/" | $path[1] = "pessoa"  |  $path[2] = "create"...
//        dd($path);
        switch ($path[1]){
            case 'cep':
                return $next($request);
                break;

            case 'home':
                return $next($request);
                break;

            case 'user':
                if(Permissao::userHasPermissao('USER')) {
                    return $next($request);
                }
                break;

            case 'person':
                if(Permissao::userHasPermissao('PERSON')) {
                   return $next($request);
                }
                break;

            case 'history':
                if(Permissao::userHasPermissao('HISTORY')) {
                    return $next($request);
                }
                break;

            case 'service':
                if(Permissao::userHasPermissao('SERVICE')) {
                    return $next($request);
                }
                break;

            case 'ticket':
                if(Permissao::userHasPermissao('TICKET')) {
                    return $next($request);
                }
                break;


        }

        //o que não cair nas regras acima, retorna erro!
        return response()->view('errors.404', [], 404);
    }
}
