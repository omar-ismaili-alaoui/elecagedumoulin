<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213230052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bdg_annonce DROP FOREIGN KEY FK_640E7B837EDDE750');
        $this->addSql('DROP INDEX IDX_640E7B837EDDE750 ON bdg_annonce');
        $this->addSql('ALTER TABLE bdg_annonce DROP bdg_annonce_image_id');
        $this->addSql('ALTER TABLE bdg_annonce_image ADD bdg_annonce_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bdg_annonce_image ADD CONSTRAINT FK_F6224BA44C5BD1AC FOREIGN KEY (bdg_annonce_id_id) REFERENCES bdg_annonce (id)');
        $this->addSql('CREATE INDEX IDX_F6224BA44C5BD1AC ON bdg_annonce_image (bdg_annonce_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bdg_annonce ADD bdg_annonce_image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bdg_annonce ADD CONSTRAINT FK_640E7B837EDDE750 FOREIGN KEY (bdg_annonce_image_id) REFERENCES bdg_annonce_image (id)');
        $this->addSql('CREATE INDEX IDX_640E7B837EDDE750 ON bdg_annonce (bdg_annonce_image_id)');
        $this->addSql('ALTER TABLE bdg_annonce_image DROP FOREIGN KEY FK_F6224BA44C5BD1AC');
        $this->addSql('DROP INDEX IDX_F6224BA44C5BD1AC ON bdg_annonce_image');
        $this->addSql('ALTER TABLE bdg_annonce_image DROP bdg_annonce_id_id');
    }
}
