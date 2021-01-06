<?php

namespace App\Controller;

use App\Entity\Prix;
use App\Entity\Race;
use App\Repository\AnnonceRepository;
use App\Repository\PrixRepository;
use App\Repository\RaceGroupRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
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
        AnnonceRepository $annonceRepository,
        RaceGroupRepository $groupRepository
    ) {
        $this->paginator = $paginator;
        $this->translator = $translator;
        $this->router = $router;
        $this->raceRepository = $raceRepository;
        $this->entityManager = $entityManager;
        $this->prixRepository = $prixRepository;
        $this->annonceRepository = $annonceRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * @Route("/", name="el_welcome")
     */
    public function index(): Response
    {
        return $this->render('Front/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/nos-races/{group}", name="el_race_group", requirements={"page"="\d+"}, defaults={"group"=1})
     */
    public function racesGroup($group): Response
    {
        $races = $this->groupRepository->find($group);
        if($races === null ){
            throw new Exception('Race not found');
        }
        return $this->render('Front/races/race-group.html.twig', [
            'races' => $races,
        ]);
    }

    /**
     * @Route("/alimentation", name="el_alimentations")
     */
    public function alimentation(): Response
    {
        return $this->render('Front/alimentation/alimentation.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/palmares", name="el_palmares")
     */
    public function palmares(): Response
    {
        return $this->render('Front/palmares/palmares.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/etalons", name="el_etalons")
     */
    public function etalons(): Response
    {
        return $this->render('Front/etalons/etalons.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/emissions-tv", name="el_emissions")
     */
    public function emissions(): Response
    {
        return $this->render('Front/emissions/emissions.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/prix", name="el_prix")
     */
    public function prix(): Response
    {
        $groupPrices = $this->groupRepository->findAll();
        return $this->render('Front/prix/prix.html.twig', [
            'groupPrices' => $groupPrices,
        ]);
    }

    /**
     * @Route("/avis", name="el_avis")
     */
    public function avis(): Response
    {
        return $this->render('Front/avis/avis.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/contact", name="el_contact")
     */
    public function contact(): Response
    {
        return $this->render('Front/contact/contact.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/dressage", name="el_dressage")
     */
    public function dressage(): Response
    {
        return $this->render('Front/dressage/dressage.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/pensions/{type}", name="el_pensions")
     */
    public function pensions(string $type): Response
    {
        if($type == 'chien'){
            $template = 'Front/pensions/pensions-chien.html.twig';
        }else{
            $template = 'Front/pensions/pensions-chat.html.twig';
        }
        return $this->render($template, [
            'controller_name' => 'DefaultController',
        ]);
    }

}
