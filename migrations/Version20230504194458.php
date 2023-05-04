<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504194458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD COLUMN author VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, titre, contenu, date_creation, state FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu CLOB NOT NULL, date_creation DATE NOT NULL, state VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO article (id, titre, contenu, date_creation, state) SELECT id, titre, contenu, date_creation, state FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
    }
}
