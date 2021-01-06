<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106115226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prix DROP INDEX UNIQ_F7EFEA5E6E59D40D, ADD INDEX IDX_F7EFEA5E6E59D40D (race_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prix DROP INDEX IDX_F7EFEA5E6E59D40D, ADD UNIQUE INDEX UNIQ_F7EFEA5E6E59D40D (race_id)');
    }
}
