<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304134744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE setting ADD COLUMN youtube_link VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__setting AS SELECT id, website_name, description, currency, tax, logo, street, city, code_postal, state, updated_at, created_at, facebook_link, instagram_link, phone FROM setting');
        $this->addSql('DROP TABLE setting');
        $this->addSql('CREATE TABLE setting (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, website_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, currency VARCHAR(255) NOT NULL, tax INTEGER DEFAULT NULL, logo VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , facebook_link VARCHAR(255) DEFAULT NULL, instagram_link VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO setting (id, website_name, description, currency, tax, logo, street, city, code_postal, state, updated_at, created_at, facebook_link, instagram_link, phone) SELECT id, website_name, description, currency, tax, logo, street, city, code_postal, state, updated_at, created_at, facebook_link, instagram_link, phone FROM __temp__setting');
        $this->addSql('DROP TABLE __temp__setting');
    }
}
