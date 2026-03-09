<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260309081635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loaning ADD CONSTRAINT FK_38DDD8D016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE loaning ADD CONSTRAINT FK_38DDD8D0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE loaning ADD CONSTRAINT FK_38DDD8D071868B2E FOREIGN KEY (book_id_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE loaning ADD CONSTRAINT FK_38DDD8D09D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loaning DROP FOREIGN KEY FK_38DDD8D016A2B381');
        $this->addSql('ALTER TABLE loaning DROP FOREIGN KEY FK_38DDD8D0A76ED395');
        $this->addSql('ALTER TABLE loaning DROP FOREIGN KEY FK_38DDD8D071868B2E');
        $this->addSql('ALTER TABLE loaning DROP FOREIGN KEY FK_38DDD8D09D86650F');
    }
}
