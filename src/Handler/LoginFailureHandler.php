<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

Class LoginFailureHandler implements AuthenticationFailureHandlerInterface {

    private $router;

    public function __construct(
        RouterInterface $router
    ){
        $this->router = $router;
    }
    /**
     * Creates a Response object to send upon a successful logout.
     *
     * @param Request $request
     *
     * @return Response never null
     */
    public function onLogoutSuccess(Request $request)
    {
        $session = new Session();
        $session->clear();
        return new RedirectResponse($this->router->generate('el_welcome'));
    }

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response The response to return, never null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        //if we are on stage or localhost or on production environment we redirect to the pdm homepage
        if ($request->getHost() == "localhost" || $request->getHost() == "elecagedumoulin.com")  {
            return new RedirectResponse($this->router->generate("el_welcome"));
        }
        else
            return new RedirectResponse($this->router->generate("el_login"));
    }
}