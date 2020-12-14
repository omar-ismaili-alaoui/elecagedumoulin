<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
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

    public function __construct(
        PaginatorInterface $paginator,
        TranslatorInterface $translator,
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        RaceRepository $raceRepository,
        PrixRepository $prixRepository,
        AnnonceRepository $annonceRepository
    ) {
        $this->paginator = $paginator;
        $this->translator = $translator;
        $this->router = $router;
        $this->raceRepository = $raceRepository;
        $this->entityManager = $entityManager;
        $this->prixRepository = $prixRepository;
        $this->annonceRepository = $annonceRepository;
    }

    /**
     * @Route("/annonces", name="el_annonces")
     */
    public function index(Request $request): Response
    {
        $allAnnonces = $this->annonceRepository->findBy([],['datePublished'=>'DESC']);
        $pagination = $this->paginator->paginate(
            $allAnnonces, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return $this->render('Front/annonces/annonces.html.twig', [
            'annonces' => $pagination,
        ]);
    }

}
