<?php

namespace App\Command;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Repository\BdgAnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RestoreAnnoncesCommand extends Command
{
    private $entityManager;
    private $siteUsersRepository;

    public function __construct(
        ?string $name = null,
        EntityManagerInterface $entityManager,
        BdgAnnonceRepository $bdgAnnonceRepository,
        AnnonceRepository $annonceRepository
    ) {
        parent::__construct($name);
        $this->entityManager = $entityManager;
        $this->bdgAnnonceRepository = $bdgAnnonceRepository;
        $this->annonceRepository = $annonceRepository;
    }
    protected function configure()
    {
        $this
            ->setName('app:restore:annonces')
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
            $newAnnonce = new Annonce();
            $newAnnonce->setTitre($value->getTitle())
                ->setUrl($value->getUrl())
                ->setContent($value->getText())
                ->setDatePublished($value->getDatePublish())
                ->setCertificat(1)
                ->setDateDispo(new \DateTime('NOW'))
                ->setDateNaissance(new \DateTime('NOW'))
                ->setLoof(1)
                ->setPortee(0)
                ->setNbTatouage('')
                ->setTaouage(1)
                ->setVaccined(1)
                ->setVermifuge(1);
            $em->persist($newAnnonce);
            $em->flush();
            $j++;
        }

        $output->writeln("Added total: ". $j . " children");
        return Command::SUCCESS;
    }
}
