<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HeaderController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('header/index.html.twig', []);
    }

    public function admin(): Response
    {
        return $this->render('header/admin.html.twig', []);
    }
}
