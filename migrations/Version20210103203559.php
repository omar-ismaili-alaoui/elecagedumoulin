<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103203559 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bdg_annonce (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date_publish DATE NOT NULL, text LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bdg_annonce_image (id INT AUTO_INCREMENT NOT NULL, bdg_annonce_id_id INT DEFAULT NULL, image VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, principal TINYINT(1) NOT NULL, INDEX IDX_F6224BA44C5BD1AC (bdg_annonce_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, pseudo VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, rating INT NOT NULL, published DATE NOT NULL, lived DATE NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_5F9E962A23EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bdg_annonce_image ADD CONSTRAINT FK_F6224BA44C5BD1AC FOREIGN KEY (bdg_annonce_id_id) REFERENCES bdg_annonce (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bdg_annonce_image DROP FOREIGN KEY FK_F6224BA44C5BD1AC');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A23EDC87');
        $this->addSql('DROP TABLE bdg_annonce');
        $this->addSql('DROP TABLE bdg_annonce_image');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE subject');
    }
}
