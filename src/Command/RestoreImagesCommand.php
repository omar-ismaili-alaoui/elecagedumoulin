<?php

namespace App\Command;

use App\Entity\Annonce;
use App\Entity\AnnonceImage;
use App\Repository\AnnonceRepository;
use App\Repository\BdgAnnonceImageRepository;
use App\Repository\BdgAnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RestoreImagesCommand extends Command
{
    private $entityManager;
    private $siteUsersRepository;

    public function __construct(
        ?string $name = null,
        EntityManagerInterface $entityManager,
        BdgAnnonceRepository $bdgAnnonceRepository,
        BdgAnnonceImageRepository $annonceImageRepository,
        AnnonceRepository $annonceRepository
    ) {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->bdgAnnonceRepository = $bdgAnnonceRepository;
        $this->annonceRepository = $annonceRepository;
        $this->annonceImageRepository = $annonceImageRepository;
    }
    protected function configure()
    {
        $this
            ->setName('app:restore:images')
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->entityManager;

        $annonces = $this->bdgAnnonceRepository->findAll();

        var_dump(count($annonces));

        $j = 0;
        foreach ($annonces as $key=>$value){
            $newAnnonce = $this->annonceRepository->findOneBy(['url'=>$value->getUrl()]);

            $oldImage = $this->annonceImageRepository->findBy(['bdgAnnonceId'=>$value->getId()]);

            foreach ($oldImage as $key2=>$image) {
                $newImage = new AnnonceImage();
                $newImage->setActive($image->getActive());
                $newImage->setPrincipal($image->getPrincipal());
                $newImage->setAnnonce($newAnnonce);
                $newImage->setImage($image->getImage());
                $em->persist($newImage);
            }

            $em->flush();

            $j++;
        }

        $output->writeln("Added total: ". $j . " children");
        return Command::SUCCESS;
    }
}
