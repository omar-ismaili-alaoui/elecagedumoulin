<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\PageRepository;
use App\Repository\PrixRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AnnoncesController extends AbstractController
{

    private $paginator;
    private $translator;
    private $router;
    private $entityManager;
    private $annonceRepository;
    private $pageRepository;

    public function __construct(
        PaginatorInterface $paginator,
        TranslatorInterface $translator,
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        AnnonceRepository $annonceRepository,
        PageRepository $pageRepository
    ) {
        $this->paginator = $paginator;
        $this->translator = $translator;
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->annonceRepository = $annonceRepository;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @Route("/annonces", name="el_annonces")
     */
    public function index(Request $request): Response
    {

        $page = $this->pageRepository->findOneBy(['url'=>'annonces']);
        $allAnnonces = $this->annonceRepository->findBy([],['datePublished'=>'DESC']);
        $pagination = $this->paginator->paginate(
            $allAnnonces, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return $this->render('Front/annonces/annonces.html.twig', [
            'page' => $page,
            'annonces' => $pagination,
        ]);
    }

}
