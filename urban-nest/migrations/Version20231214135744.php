<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231214135744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE real_estate_annoucement_candidates CHANGE message message LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE real_estate_annoucement_candidates_documents ADD document_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE real_estate_annoucement_candidates CHANGE message message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE real_estate_annoucement_candidates_documents DROP document_name');
    }
}
