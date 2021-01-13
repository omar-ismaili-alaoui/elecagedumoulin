<?php

namespace App\Controller;

use App\Entity\Prix;
use App\Entity\Race;
use App\Repository\AnnonceRepository;
use App\Repository\CommentsRepository;
use App\Repository\PageRepository;
use App\Repository\PrixRepository;
use App\Repository\RaceGroupRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
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
    private $raceRepository;
    private $prixRepository;
    private $annonceRepository;
    private $groupRepository;
    private $commentsRepository;
    private $pageRepository;

    public function __construct(
        PaginatorInterface $paginator,
        TranslatorInterface $translator,
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        RaceRepository $raceRepository,
        PrixRepository $prixRepository,
        AnnonceRepository $annonceRepository,
        RaceGroupRepository $groupRepository,
        CommentsRepository $commentsRepository,
        PageRepository $pageRepository
    ) {
        $this->paginator = $paginator;
        $this->translator = $translator;
        $this->router = $router;
        $this->raceRepository = $raceRepository;
        $this->entityManager = $entityManager;
        $this->prixRepository = $prixRepository;
        $this->annonceRepository = $annonceRepository;
        $this->groupRepository = $groupRepository;
        $this->commentsRepository = $commentsRepository;
        $this->pageRepository = $pageRepository;
    }

    /**
     * @Route("/", name="el_welcome")
     */
    public function index(): Response
    {
        $page = $this->pageRepository->findOneBy(['url'=>'/']);
        return $this->render('Front/index.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/mentions-legales", name="el_mentions")
     */
    public function mentions(): Response
    {
        $page = $this->pageRepository->findOneBy(['url'=>'/']);
        return $this->render('Front/mentions/mentions-legales.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/nos-races/{group}", name="el_race_group", requirements={"page"="\s+"})
     */
    public function racesGroup($group): Response
    {
        $races = $this->groupRepository->findOneBy(['url'=>$group]);
        switch($races->getTitre()){
            case 'Épagneule breton bicolore':
                $page = $this->pageRepository->findOneBy(['url'=>'chiots-epagneuls-bretons']);
                break;
            case 'Épagneule breton tricolore':
                $page = $this->pageRepository->findOneBy(['url'=>'chiots-epagneuls-bretons']);
                break;
            case 'Griffon Korthal':
                $page = $this->pageRepository->findOneBy(['url'=>'chiots-griffons-krothals']);
                break;
            case 'Labrador du retriever':
                $page = $this->pageRepository->findOneBy(['url'=>'chiots-labradors']);
                break;
        }
        if($races === null ){
            throw new Exception('Race not found');
        }
        return $this->render('Front/races/race-group.html.twig', [
            'page' => $page,
            'races' => $races,
        ]);
    }

    /**
     * @Route("/alimentation", name="el_alimentations")
     */
    public function alimentation(): Response
    {
        $page = $this->pageRepository->findOneBy(['url'=>'alimentation-et-recommandation']);
        return $this->render('Front/alimentation/alimentation.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @Route("/palmares", name="el_palmares")
     */
    public function palmares(): Response
    {
        $page = $this->pageRepository->findOneBy(['url'=>'palmares']);
        return $this->render('Front/palmares/palmares.html.twig', [
            'page' => $page,
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
        $page = $this->pageRepository->findOneBy(['url'=>'prix']);
        $groupPrices = $this->groupRepository->findAll();
        return $this->render('Front/prix/prix.html.twig', [
            'groupPrices' => $groupPrices,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/avis", name="el_avis")
     */
    public function avis(Request $request): Response
    {
        $page = $this->pageRepository->findOneBy(['url'=>'avis']);
        $allComments = $this->commentsRepository->findBy([],['id'=>'DESC']);
        $countComments = count($allComments);
        $allComments = $this->paginator->paginate(
            $allComments,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('Front/avis/avis.html.twig', [
            'countComments' => $countComments,
            'allComments' => $allComments,
            'page' => $page,
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
        $page = $this->pageRepository->findOneBy(['url'=>'dressage']);
        return $this->render('Front/dressage/dressage.html.twig', [
            'page' => $page
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
