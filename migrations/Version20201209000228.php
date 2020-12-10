<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209000228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sexe (id INT AUTO_INCREMENT NOT NULL, sexe VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE race ADD sexe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE race ADD CONSTRAINT FK_DA6FBBAF448F3B3C FOREIGN KEY (sexe_id) REFERENCES sexe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA6FBBAF448F3B3C ON race (sexe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race DROP FOREIGN KEY FK_DA6FBBAF448F3B3C');
        $this->addSql('DROP TABLE sexe');
        $this->addSql('DROP INDEX UNIQ_DA6FBBAF448F3B3C ON race');
        $this->addSql('ALTER TABLE race DROP sexe_id');
    }
}
