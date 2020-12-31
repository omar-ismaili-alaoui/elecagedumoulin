<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\AnnonceImage;
use App\Entity\Prix;
use App\Entity\Race;
use App\Form\AnnonceImageType;
use App\Form\AnnonceType;
use App\Form\PrixType;
use App\Form\RaceType;
use App\Repository\AnnonceImageRepository;
use App\Repository\AnnonceRepository;
use App\Repository\PrixRepository;
use App\Repository\RaceRepository;
use App\Services\TextUtils;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use mysql_xdevapi\Exception;
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

    private $cropperServices;

    public function __construct(
        PaginatorInterface $paginator,
        TranslatorInterface $translator,
        RouterInterface $router,
        EntityManagerInterface $entityManager,
        RaceRepository $raceRepository,
        PrixRepository $prixRepository,
        AnnonceRepository $annonceRepository,
        AnnonceImageRepository $annonceImageRepository,
        TextUtils $textUtils
    ) {
        $this->paginator = $paginator;
        $this->translator = $translator;
        $this->router = $router;
        $this->raceRepository = $raceRepository;
        $this->entityManager = $entityManager;
        $this->prixRepository = $prixRepository;
        $this->annonceRepository = $annonceRepository;
        $this->annonceImageRepository = $annonceImageRepository;
        $this->textUtils = $textUtils;
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
     * @Route("/add-annonce/{id}", name="admin_annonce_edit")
     */
    public function annonceAdd(Request $request, $id = null): Response
    {
        if($id) {
            $annonce = $this->annonceRepository->find($id);
            $state = "edit";
        }else{
            $annonce = new Annonce();
            $state = "new";
        }

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()){
                $annoncesSameUrl = $this->annonceRepository->findBy(['url'=>$this->textUtils->slugify($annonce->getTitre())]);
                if($annoncesSameUrl){
                    $annonce->setUrl($this->textUtils->slugify($annonce->getTitre().'-'.(sizeof($annoncesSameUrl)+1)));
                }else{
                    $annonce->setUrl($this->textUtils->slugify($annonce->getTitre()));
                }
                $this->entityManager->persist($annonce);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_annonces');
            }else{
                dd($form->getErrors());
            }
        }
        if($state == 'edit'){
            $images = $this->annonceImageRepository->findBy(['annonce'=>$annonce]);
            $images = $this->paginator->paginate(
                $images, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                20/*limit per page*/
            );
        }else{
            $images = null;
        }
        return $this->render('Admin/annonces/annonce-add.html.twig', [
            'form' => $form->createView(),
            'state' => $state,
            'images' => $images,
            'annonceUrl' => $annonce->getUrl()
        ]);
    }

    /**
     * @Route("/add-annonce/images/{url}", name="admin_annonces_images_add")
     * @Route("/add-annonce/images/{id}/{url}", name="admin_annonces_images_edit")
     */
    public function annonceImagesAdd(Request $request, $id = null, $url = null): Response
    {
        if($id) {
            $image = $this->annonceImageRepository->find($id);
            $state = "edit";
        }else{
            $image = new AnnonceImage();
            $state = "new";
        }
        $annonce = $this->annonceRepository->findOneBy(['url'=>$url]);
        if($annonce == null){
            throw new Exception('No article founded');
        }
        $image->setAnnonce($annonce);
        $form = $this->createForm(AnnonceImageType::class, $image);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->entityManager->persist($image);
                $this->entityManager->flush();
                return $this->redirectToRoute('admin_annonces_images_add',['url'=>$url]);
            }
        }
        return $this->render('Admin/annonces-images/annonce-images-add.html.twig', [
            'form' => $form->createView(),
            'state' => $state,
            'annonce' => $annonce
        ]);
    }

    // CROPING BLOG BADGES
    /**
     * @Route("/default/uploadTempFile/{tempFolder}", name="upload_temp_file")
     */
    public function uploadTempFileAction($tempFolder){
        $userId = $this->getUser()->getId();
        $target_dir = realpath('uploads/'.$tempFolder.'/temp-files');
        $target_file = $target_dir .'/'.$userId.'-'. basename($_FILES["fileBB"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $gen = $this->generateSecret('',8,'');
        $target_file = substr($target_file,0,-4);
        $target_file = str_replace(' ','-',$target_file);
        $target_file = $target_file . '-' . $gen . '.' . $imageFileType;
        $name = substr(basename($_FILES["fileBB"]["name"]),0,-4);
        $name = str_replace(' ','-',$name);
        // Check if image file is a actual image or fake image
        if(isset($_POST)) {
            $check = getimagesize($_FILES["fileBB"]["tmp_name"]);
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        $imagedetails = getimagesize($_FILES['fileBB']['tmp_name']);

        $width = $imagedetails[0];
        $height = $imagedetails[1];
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileBB"]["tmp_name"], $target_file)) {
                //$this->imageCropping($target_file);
                //echo "The file ". basename( $_FILES["fileBB"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        if($imageFileType == "png" || $imageFileType == "PNG") {
            $nameTwo = substr($target_file,0,-4);
            $JPG = $this->png2jpg($target_file,$nameTwo.'.jpg',100);
            echo '/'.$tempFolder.'/temp-files/'.$userId.'-'.$name.'-'.$gen.'.'.'jpg'.'***'.$width.'***'.$height;
        }else{
            echo '/'.$tempFolder.'/temp-files/'.$userId.'-'.$name.'-'.$gen.'.'.$imageFileType .'***'.$width.'***'.$height;
        }
        exit();
    }

    /**
     * @Route("/default/cropFile", name="crop_file")
     */
    public function cropFileAction(Request $request){
        $dateNow = (new \DateTime('NOW'))->getTimestamp();
        $userId = $this->getUser()->getId();
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $newFileName = $userId.'-'.$dateNow.'.jpg';
            $srcFile = 'uploads/'.$_POST['folder'].'/' . $newFileName;
            move_uploaded_file($_FILES['file']['tmp_name'], $srcFile);
            list($width, $height) = getimagesize($srcFile);

            echo ''.$_POST['folder'].'/640x'.((640*$height)/$width).'_art_'.$newFileName;
            $this->createThumbImageFromOriginalImage($srcFile,640,((640*$height)/$width),$srcFile,$newFileName,'');
        }
        exit();
    }

    function createThumbImageFromOriginalImage($src,$newWidth,$newHeight,$realPath,$newFileName,$path){
        list($width, $height) = getimagesize($src);
        $thumb = imagecreatetruecolor($newWidth,$newHeight);
        $source = imagecreatefromstring( file_get_contents( $realPath ) );
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth,$newHeight, $width, $height);
        imagepng( $thumb,(realpath('uploads/'.$_POST['folder']).'/'.$path.'/'.$newWidth.'x'.$newHeight.'_art_'.$newFileName.''));
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
     * @Route("/edit-price/{id}", name="admin_prices_edit")
     */
    public function pricesAdd(Request $request,$id = null): Response
    {
        if($id){
            $price = $this->prixRepository->find($id);
            $state = "edit";
        }else{
            $price = new Prix();
            $state = "new";
        }
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
            'state' => $state
        ]);
    }

    public function generateSecret($userId_,$length_,$salt_){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length_; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString.$salt_.base64_encode($userId_);
    }

}
