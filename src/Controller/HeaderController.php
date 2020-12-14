<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HeaderController extends AbstractController
{

    public function index($route, $group, $type): Response
    {
        return $this->render('Front/header/index.html.twig', [
            'route'=>$route,
            'group'=>$group,
            'type'=>$type
        ]);
    }

}
