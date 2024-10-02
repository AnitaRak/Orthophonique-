<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304063329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD sequence INT NOT NULL');
        $this->addSql('ALTER TABLE template_question CHANGE instructions_fr instructions_fr VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE test ADD active TINYINT(1) NOT NULL, CHANGE instructions_fr instructions_fr VARCHAR(800) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP sequence');
        $this->addSql('ALTER TABLE template_question CHANGE instructions_fr instructions_fr VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE test DROP active, CHANGE instructions_fr instructions_fr VARCHAR(255) NOT NULL');
    }
}
