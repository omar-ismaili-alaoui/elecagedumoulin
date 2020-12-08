<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208213728 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, race_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date_published DATETIME NOT NULL, content LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F65593E56E59D40D (race_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_image (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, principal TINYINT(1) NOT NULL, INDEX IDX_D2B0CFC08805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_video (id INT AUTO_INCREMENT NOT NULL, annonce_id INT DEFAULT NULL, url_code VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_6B4A11B38805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E56E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE annonce_image ADD CONSTRAINT FK_D2B0CFC08805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE annonce_video ADD CONSTRAINT FK_6B4A11B38805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce_video (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce_image DROP FOREIGN KEY FK_D2B0CFC08805AB2F');
        $this->addSql('ALTER TABLE annonce_video DROP FOREIGN KEY FK_6B4A11B38805AB2F');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E56E59D40D');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonce_image');
        $this->addSql('DROP TABLE annonce_video');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE user');
    }
}
