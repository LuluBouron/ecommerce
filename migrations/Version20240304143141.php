<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304143141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__slider AS SELECT id, title, description, button_test, button_link, image_url, updated_at, created_at FROM slider');
        $this->addSql('DROP TABLE slider');
        $this->addSql('CREATE TABLE slider (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, button_text VARCHAR(255) NOT NULL, button_link VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO slider (id, title, description, button_text, button_link, image_url, updated_at, created_at) SELECT id, title, description, button_test, button_link, image_url, updated_at, created_at FROM __temp__slider');
        $this->addSql('DROP TABLE __temp__slider');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__slider AS SELECT id, title, description, button_text, button_link, image_url, updated_at, created_at FROM slider');
        $this->addSql('DROP TABLE slider');
        $this->addSql('CREATE TABLE slider (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, button_test VARCHAR(255) NOT NULL, button_link VARCHAR(255) NOT NULL, image_url VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO slider (id, title, description, button_test, button_link, image_url, updated_at, created_at) SELECT id, title, description, button_text, button_link, image_url, updated_at, created_at FROM __temp__slider');
        $this->addSql('DROP TABLE __temp__slider');
    }
}
