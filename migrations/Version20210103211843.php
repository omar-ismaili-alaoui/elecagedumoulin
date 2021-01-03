<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103211843 extends AbstractMigration
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
        $this->addSql('ALTER TABLE bdg_annonce_image ADD CONSTRAINT FK_F6224BA44C5BD1AC FOREIGN KEY (bdg_annonce_id_id) REFERENCES bdg_annonce (id)');
        $this->addSql('ALTER TABLE comments CHANGE pseudo pseudo VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL, CHANGE titre titre VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bdg_annonce_image DROP FOREIGN KEY FK_F6224BA44C5BD1AC');
        $this->addSql('DROP TABLE bdg_annonce');
        $this->addSql('DROP TABLE bdg_annonce_image');
        $this->addSql('ALTER TABLE comments CHANGE pseudo pseudo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE titre titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
