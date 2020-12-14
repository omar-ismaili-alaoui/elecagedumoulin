<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214201855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE race_group_images (id INT AUTO_INCREMENT NOT NULL, race_group_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_D3C53F50AE4E18AE (race_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE race_group_images ADD CONSTRAINT FK_D3C53F50AE4E18AE FOREIGN KEY (race_group_id) REFERENCES race_group (id)');
        $this->addSql('ALTER TABLE race_group DROP image');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE race_group_images');
        $this->addSql('ALTER TABLE race_group ADD image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
