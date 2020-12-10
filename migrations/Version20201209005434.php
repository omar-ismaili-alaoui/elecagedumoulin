<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209005434 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race DROP INDEX UNIQ_DA6FBBAF448F3B3C, ADD INDEX IDX_DA6FBBAF448F3B3C (sexe_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race DROP INDEX IDX_DA6FBBAF448F3B3C, ADD UNIQUE INDEX UNIQ_DA6FBBAF448F3B3C (sexe_id)');
    }
}
