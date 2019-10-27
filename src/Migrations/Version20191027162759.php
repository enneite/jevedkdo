<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191027162759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_2CCE0CB3A76ED395');
        $this->addSql('DROP INDEX UNIQ_2CCE0CB397A95A83');
        $this->addSql('CREATE TEMPORARY TABLE __temp__positionning AS SELECT id, gift_id, user_id, comments FROM positionning');
        $this->addSql('DROP TABLE positionning');
        $this->addSql('CREATE TABLE positionning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gift_id INTEGER NOT NULL, user_id INTEGER NOT NULL, comments CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_2CCE0CB397A95A83 FOREIGN KEY (gift_id) REFERENCES gift (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2CCE0CB3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO positionning (id, gift_id, user_id, comments) SELECT id, gift_id, user_id, comments FROM __temp__positionning');
        $this->addSql('DROP TABLE __temp__positionning');
        $this->addSql('CREATE INDEX IDX_2CCE0CB3A76ED395 ON positionning (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CCE0CB397A95A83 ON positionning (gift_id)');
        $this->addSql('DROP INDEX IDX_D7D174C9A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__wish AS SELECT id, user_id, status, title, description FROM wish');
        $this->addSql('DROP TABLE wish');
        $this->addSql('CREATE TABLE wish (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, status VARCHAR(255) NOT NULL COLLATE BINARY, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_D7D174C9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO wish (id, user_id, status, title, description) SELECT id, user_id, status, title, description FROM __temp__wish');
        $this->addSql('DROP TABLE __temp__wish');
        $this->addSql('CREATE INDEX IDX_D7D174C9A76ED395 ON wish (user_id)');
        $this->addSql('DROP INDEX IDX_A47C990D8DF54221');
        $this->addSql('CREATE TEMPORARY TABLE __temp__gift AS SELECT id, whish_id, title, description FROM gift');
        $this->addSql('DROP TABLE gift');
        $this->addSql('CREATE TABLE gift (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, wish_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_A47C990D42B83698 FOREIGN KEY (wish_id) REFERENCES wish (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO gift (id, wish_id, title, description) SELECT id, whish_id, title, description FROM __temp__gift');
        $this->addSql('DROP TABLE __temp__gift');
        $this->addSql('CREATE INDEX IDX_A47C990D42B83698 ON gift (wish_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_A47C990D42B83698');
        $this->addSql('CREATE TEMPORARY TABLE __temp__gift AS SELECT id, wish_id, title, description FROM gift');
        $this->addSql('DROP TABLE gift');
        $this->addSql('CREATE TABLE gift (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, whish_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO gift (id, whish_id, title, description) SELECT id, wish_id, title, description FROM __temp__gift');
        $this->addSql('DROP TABLE __temp__gift');
        $this->addSql('CREATE INDEX IDX_A47C990D8DF54221 ON gift (whish_id)');
        $this->addSql('DROP INDEX UNIQ_2CCE0CB397A95A83');
        $this->addSql('DROP INDEX IDX_2CCE0CB3A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__positionning AS SELECT id, gift_id, user_id, comments FROM positionning');
        $this->addSql('DROP TABLE positionning');
        $this->addSql('CREATE TABLE positionning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gift_id INTEGER NOT NULL, user_id INTEGER NOT NULL, comments CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO positionning (id, gift_id, user_id, comments) SELECT id, gift_id, user_id, comments FROM __temp__positionning');
        $this->addSql('DROP TABLE __temp__positionning');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CCE0CB397A95A83 ON positionning (gift_id)');
        $this->addSql('CREATE INDEX IDX_2CCE0CB3A76ED395 ON positionning (user_id)');
        $this->addSql('DROP INDEX IDX_D7D174C9A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__wish AS SELECT id, user_id, status, title, description FROM wish');
        $this->addSql('DROP TABLE wish');
        $this->addSql('CREATE TABLE wish (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, status VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO wish (id, user_id, status, title, description) SELECT id, user_id, status, title, description FROM __temp__wish');
        $this->addSql('DROP TABLE __temp__wish');
        $this->addSql('CREATE INDEX IDX_D7D174C9A76ED395 ON wish (user_id)');
    }
}
