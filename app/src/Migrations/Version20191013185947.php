<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191013185947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, datetime DATETIME NOT NULL, source VARCHAR(255) NOT NULL, language VARCHAR(20) NOT NULL, sport VARCHAR(30) NOT NULL, league VARCHAR(30) NOT NULL, team_one VARCHAR(30) NOT NULL, team_two VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_buffer_token (id INT AUTO_INCREMENT NOT NULL, game_buffer_id INT NOT NULL, language VARCHAR(20) NOT NULL, sport VARCHAR(30) NOT NULL, league VARCHAR(30) NOT NULL, team_one VARCHAR(30) NOT NULL, team_two VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_AAA8F1E79DA5FAEA (game_buffer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_buffer (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, datetime DATETIME NOT NULL, source VARCHAR(255) NOT NULL, language VARCHAR(20) NOT NULL, sport VARCHAR(30) NOT NULL, league VARCHAR(30) NOT NULL, team_one VARCHAR(30) NOT NULL, team_two VARCHAR(30) NOT NULL, INDEX IDX_4C6F5D3AE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_buffer_token ADD CONSTRAINT FK_AAA8F1E79DA5FAEA FOREIGN KEY (game_buffer_id) REFERENCES game_buffer (id)');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3AE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_buffer DROP FOREIGN KEY FK_4C6F5D3AE48FD905');
        $this->addSql('ALTER TABLE game_buffer_token DROP FOREIGN KEY FK_AAA8F1E79DA5FAEA');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_buffer_token');
        $this->addSql('DROP TABLE game_buffer');
    }
}
