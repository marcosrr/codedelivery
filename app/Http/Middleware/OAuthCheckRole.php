<?php

namespace CodeDelivery\Http\Middleware;

use Closure;
use LucaDegasperi\OAuth2Server\Facades\Authorizer; //ou só: use Authorizer;
use CodeDelivery\Repositories\UserRepository;

class OAuthCheckRole
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role) //aqui adicionamos um parametro para o middleware
    {

        $id =  Authorizer::getResourceOwnerId(); //Pegar ID do usuário autenticado com OAuth
        $user = $this->userRepository->find($id);

        if($user->role != $role){
            abort(403, 'Acesso negado');
        }
        return $next($request);
    }
}
