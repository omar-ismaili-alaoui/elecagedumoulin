<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Prix;
use App\Entity\Race;
use App\Form\AnnonceType;
use App\Form\PrixType;
use App\Form\RaceType;
use App\Repository\AnnonceRepository;
use App\Repository\PrixRepository;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    private $paginator;
    private $translator;
    private $mailer;
    private $session;
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
     * @Route("/", name="admin_homepage")
     */
    public function index(): Response
    {
        return $this->render('Admin/index.html.twig', []);
    }

    /**
     * @Route("/login", name="security_admin_login")
     */
    public function login(){
        return $this->render('Security/admin-login.html.twig', []);
    }

    /**
     * @Route("/logout", name="security_admin_logout")
     */
    public function logout(): Response {}


    public function leftbar($route){
        return $this->render('Admin/leftbar/index.html.twig', [
            'route'=>$route
        ]);
    }

    public function header(){
        return $this->render('Admin/header/index.html.twig', []);
    }

    /**
     * @Route("/races", name="admin_races")
     */
    public function races(Request $request): Response
    {
        $allRaces = $this->raceRepository->findAll();
        $pagination = $this->paginator->paginate(
            $allRaces, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return $this->render('Admin/races/races-list.html.twig', [
            'allRaces' => $pagination,
        ]);
    }

    /**
     * @Route("/add-race", name="admin_races_add")
     */
    public function racesAdd(Request $request): Response
    {
        $race = new Race();
        $form = $this->createForm(RaceType::class, $race);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $race->setTitre($request->get('race')['titre']);
            $race->setActive($request->get('race')['active']);
            $this->entityManager->persist($race);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_races');
        }
        return $this->render('Admin/races/races-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-race/{id}", name="admin_races_edit")
     */
    public function racesEdit(Request $request, Race $id): Response
    {
        $raceFound = $this->raceRepository->find($id);

        if($raceFound != null){
            $form = $this->createForm(RaceType::class, $raceFound);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $raceFound->setTitre($request->get('race')['titre']);
                $raceFound->setActive($request->get('race')['active']);
                $this->entityManager->persist($raceFound);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_races');
            }
        }
        return $this->render('Admin/races/races-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/annonces", name="admin_annonces")
     */
    public function annonces(Request $request): Response
    {
        $allAnnonces = $this->annonceRepository->findAll();
        $allAnnonces = $this->paginator->paginate(
            $allAnnonces,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('Admin/annonces/annoces-list.html.twig', [
            'allAnnonces' => $allAnnonces,
        ]);
    }

    /**
     * @Route("/add-annonce", name="admin_annonce_add")
     */
    public function annonceAdd(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /*$price->setPrix($request->get('prix')['prix']);
            $price->setRace($this->raceRepository->find($request->get('prix')['race']));
            $this->entityManager->persist($price);
            $this->entityManager->flush();*/
            return $this->redirectToRoute('admin_annonces');
        }
        return $this->render('Admin/annonces/annonce-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/commentaires", name="admin_commentaires")
     */
    public function commentaire(): Response
    {
        $allRaces = $this->raceRepository->findAll();
        return $this->render('Admin/prix/prix-list.html.twig', [
            'allRaces' => $allRaces,
        ]);
    }

    /**
     * @Route("/prix", name="admin_prix")
     */
    public function prix(): Response
    {
        $allPrices = $this->prixRepository->findAll();
        return $this->render('Admin/prix/prix-list.html.twig', [
            'allPrices' => $allPrices,
        ]);
    }

    /**
     * @Route("/add-price", name="admin_prices_add")
     */
    public function pricesAdd(Request $request): Response
    {
        $price = new Prix();
        $form = $this->createForm(PrixType::class, $price);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $price->setPrix($request->get('prix')['prix']);
            $price->setRace($this->raceRepository->find($request->get('prix')['race']));
            $this->entityManager->persist($price);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_prix');
        }
        return $this->render('Admin/prix/prix-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-price/{id}", name="admin_prices_edit")
     */
    public function pricesEdit(Request $request, Prix $id): Response
    {
        $priceFound = $this->prixRepository->find($id);
        if($priceFound != null){
            $form = $this->createForm(PrixType::class, $priceFound);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $priceFound->setPrix($request->get('prix')['prix']);
                $priceFound->setRace($this->raceRepository->find($request->get('prix')['race']));
                $this->entityManager->persist($priceFound);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_prix');
            }
        }
        return $this->render('Admin/prix/prix-edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
