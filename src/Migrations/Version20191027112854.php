<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191027112854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE positionning (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gift_id INTEGER NOT NULL, user_id INTEGER NOT NULL, comments CLOB DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2CCE0CB397A95A83 ON positionning (gift_id)');
        $this->addSql('CREATE INDEX IDX_2CCE0CB3A76ED395 ON positionning (user_id)');
        $this->addSql('CREATE TABLE wish (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, status VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_D7D174C9A76ED395 ON wish (user_id)');
        $this->addSql('CREATE TABLE gift (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, whish_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_A47C990D8DF54221 ON gift (whish_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE positionning');
        $this->addSql('DROP TABLE wish');
        $this->addSql('DROP TABLE gift');
    }
}
