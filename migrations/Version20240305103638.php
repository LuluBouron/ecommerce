<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305103638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, slug, description, more_description, additional_infos, stock, solde_price, regular_price, image_urls, brand, is_available, is_best_seller, is_new_arrival, is_featured, is_special_offer, created_at, updated_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, related_products_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, more_description VARCHAR(1000) DEFAULT NULL, additional_infos VARCHAR(255) DEFAULT NULL, stock INTEGER DEFAULT NULL, solde_price INTEGER DEFAULT NULL, regular_price INTEGER NOT NULL, image_urls CLOB NOT NULL --(DC2Type:array)
        , brand VARCHAR(255) DEFAULT NULL, is_available BOOLEAN DEFAULT NULL, is_best_seller BOOLEAN DEFAULT NULL, is_new_arrival BOOLEAN DEFAULT NULL, is_featured BOOLEAN DEFAULT NULL, is_special_offer BOOLEAN DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_D34A04ADA761FF2D FOREIGN KEY (related_products_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, name, slug, description, more_description, additional_infos, stock, solde_price, regular_price, image_urls, brand, is_available, is_best_seller, is_new_arrival, is_featured, is_special_offer, created_at, updated_at) SELECT id, name, slug, description, more_description, additional_infos, stock, solde_price, regular_price, image_urls, brand, is_available, is_best_seller, is_new_arrival, is_featured, is_special_offer, created_at, updated_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04ADA761FF2D ON product (related_products_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, name, slug, description, more_description, additional_infos, stock, solde_price, regular_price, image_urls, brand, is_available, is_best_seller, is_new_arrival, is_featured, is_special_offer, created_at, updated_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, more_description VARCHAR(1000) DEFAULT NULL, additional_infos VARCHAR(255) DEFAULT NULL, stock INTEGER DEFAULT NULL, solde_price INTEGER DEFAULT NULL, regular_price INTEGER NOT NULL, image_urls CLOB NOT NULL --(DC2Type:array)
        , brand VARCHAR(255) DEFAULT NULL, is_available BOOLEAN DEFAULT NULL, is_best_seller BOOLEAN DEFAULT NULL, is_new_arrival BOOLEAN DEFAULT NULL, is_featured BOOLEAN DEFAULT NULL, is_special_offer BOOLEAN DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , updated_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO product (id, name, slug, description, more_description, additional_infos, stock, solde_price, regular_price, image_urls, brand, is_available, is_best_seller, is_new_arrival, is_featured, is_special_offer, created_at, updated_at) SELECT id, name, slug, description, more_description, additional_infos, stock, solde_price, regular_price, image_urls, brand, is_available, is_best_seller, is_new_arrival, is_featured, is_special_offer, created_at, updated_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
    }
}
