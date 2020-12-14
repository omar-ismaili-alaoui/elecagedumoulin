<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213225827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bdg_annonce_image (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, principal TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bdg_annonce ADD bdg_annonce_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bdg_annonce ADD CONSTRAINT FK_640E7B837EDDE750 FOREIGN KEY (bdg_annonce_image_id) REFERENCES bdg_annonce_image (id)');
        $this->addSql('CREATE INDEX IDX_640E7B837EDDE750 ON bdg_annonce (bdg_annonce_image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bdg_annonce DROP FOREIGN KEY FK_640E7B837EDDE750');
        $this->addSql('DROP TABLE bdg_annonce_image');
        $this->addSql('DROP INDEX IDX_640E7B837EDDE750 ON bdg_annonce');
        $this->addSql('ALTER TABLE bdg_annonce DROP bdg_annonce_image_id');
    }
}
