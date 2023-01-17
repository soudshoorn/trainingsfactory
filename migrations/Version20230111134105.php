<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111134105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F352128132');
        $this->addSql('DROP INDEX IDX_F87474F352128132 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP lesson_user_id');
        $this->addSql('ALTER TABLE lesson_user ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson_user ADD CONSTRAINT FK_B4E2102DCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_B4E2102DCDF80196 ON lesson_user (lesson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson ADD lesson_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F352128132 FOREIGN KEY (lesson_user_id) REFERENCES lesson_user (id)');
        $this->addSql('CREATE INDEX IDX_F87474F352128132 ON lesson (lesson_user_id)');
        $this->addSql('ALTER TABLE lesson_user DROP FOREIGN KEY FK_B4E2102DCDF80196');
        $this->addSql('DROP INDEX IDX_B4E2102DCDF80196 ON lesson_user');
        $this->addSql('ALTER TABLE lesson_user DROP lesson_id');
    }
}
