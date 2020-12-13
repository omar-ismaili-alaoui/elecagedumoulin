<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210131105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce ADD vermifuge TINYINT(1) NOT NULL, ADD taouage TINYINT(1) NOT NULL, ADD vaccined TINYINT(1) NOT NULL, ADD loof TINYINT(1) NOT NULL, ADD date_naissance DATE NOT NULL, ADD date_dispo DATE NOT NULL, ADD portee INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP vermifuge, DROP taouage, DROP vaccined, DROP loof, DROP date_naissance, DROP date_dispo, DROP portee');
    }
}
