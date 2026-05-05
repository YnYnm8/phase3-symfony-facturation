<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504100841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, name, email, phone, adress, siret, rib, owner_id FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, siret VARCHAR(255) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, owner_id INTEGER NOT NULL, CONSTRAINT FK_C74404557E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, name, email, phone, adress, siret, rib, owner_id) SELECT id, name, email, phone, adress, siret, rib, owner_id FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE INDEX IDX_C74404557E3C61F9 ON client (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, name, email, phone, adress, siret, rib, owner_id FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, rib VARCHAR(255) NOT NULL, owner_id INTEGER NOT NULL, CONSTRAINT FK_C74404557E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, name, email, phone, adress, siret, rib, owner_id) SELECT id, name, email, phone, adress, siret, rib, owner_id FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE INDEX IDX_C74404557E3C61F9 ON client (owner_id)');
    }
}
