<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210123133252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_offer ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE type type DEFAULT \'APP\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job_offer DROP created_at');
        $this->addSql('ALTER TABLE user CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'APP\' COLLATE `utf8mb4_unicode_ci`');
    }
}
