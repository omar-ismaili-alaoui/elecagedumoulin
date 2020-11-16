<?php

namespace App\Handler;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

Class LogoutSuccessHandler implements  LogoutSuccessHandlerInterface {

    private $router;
    private $flashBag;

    public function __construct(
        RouterInterface $router,
        FlashBagInterface $flashBag
    ){
        $this->router = $router;
        $this->flashBag = $flashBag;
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
        if ($request->query->has("identificationChanged")) {
            return new RedirectResponse($this->router->generate('mayane_logout_new_identification'));
        }
        return new RedirectResponse($this->router->generate('mayane_welcome'));
    }
}