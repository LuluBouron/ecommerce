<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305092713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collections ADD COLUMN is_mega BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__collections AS SELECT id, title, description, button_text, button_link, image_url, updated_at, created_at FROM collections');
        $this->addSql('DROP TABLE collections');
        $this->addSql('CREATE TABLE collections (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, button_text VARCHAR(255) NOT NULL, button_link VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO collections (id, title, description, button_text, button_link, image_url, updated_at, created_at) SELECT id, title, description, button_text, button_link, image_url, updated_at, created_at FROM __temp__collections');
        $this->addSql('DROP TABLE __temp__collections');
    }
}
