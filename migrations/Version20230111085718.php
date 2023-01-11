<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111085718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson CHANGE date date DATE NOT NULL, CHANGE begin_time begin_time TIME NOT NULL, CHANGE end_time end_time TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson CHANGE date date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE begin_time begin_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', CHANGE end_time end_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\'');
    }
}
