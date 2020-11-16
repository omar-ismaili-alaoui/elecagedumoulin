<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_homepage")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

    /**
     * @Route("/admin/login", name="security_admin_login")
     */
    public function login(){
        return $this->render('Security/admin-login.html.twig', []);
    }

    /**
     * @Route("/admin/logout", name="security_admin_logout")
     */
    public function logout(): Response {}

}
