<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208235210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE prix (id INT AUTO_INCREMENT NOT NULL, race_id INT DEFAULT NULL, prix VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F7EFEA5E6E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prix ADD CONSTRAINT FK_F7EFEA5E6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE race ADD couleur VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE prix');
        $this->addSql('ALTER TABLE race DROP couleur');
    }
}
