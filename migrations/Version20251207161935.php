<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251207161935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE games DROP FOREIGN KEY `FK_FF232B3145185D02`');
        $this->addSql('ALTER TABLE games DROP FOREIGN KEY `FK_FF232B319C4C13F6`');
        $this->addSql('ALTER TABLE predictions DROP FOREIGN KEY `FK_8E87BCE6A76ED395`');
        $this->addSql('ALTER TABLE predictions DROP FOREIGN KEY `FK_8E87BCE6E48FD905`');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE predictions');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE teams');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY `FK_1483A5E9D60322AC`');
        $this->addSql('DROP INDEX IDX_1483A5E9D60322AC ON users');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(255) NOT NULL, CHANGE role_id role_id INT DEFAULT 2 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE games (id INT AUTO_INCREMENT NOT NULL, uid INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, home_goals INT DEFAULT NULL, away_goals INT DEFAULT NULL, state VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'Not started\' NOT NULL COLLATE `utf8mb4_0900_ai_ci`, start_time DATETIME DEFAULT NULL, home_team_id INT NOT NULL, away_team_id INT NOT NULL, INDEX IDX_FF232B3145185D02 (away_team_id), INDEX IDX_FF232B319C4C13F6 (home_team_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE predictions (id INT AUTO_INCREMENT NOT NULL, home_prediction INT NOT NULL, away_prediction INT NOT NULL, points INT DEFAULT 0 NOT NULL, prediction_time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, is_open TINYINT DEFAULT 1 NOT NULL, user_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_8E87BCE6A76ED395 (user_id), INDEX IDX_8E87BCE6E48FD905 (game_id), UNIQUE INDEX user_game_unique (user_id, game_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, flag VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, is_finalist TINYINT DEFAULT 1 NOT NULL, UNIQUE INDEX UNIQ_96C222585E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE games ADD CONSTRAINT `FK_FF232B3145185D02` FOREIGN KEY (away_team_id) REFERENCES teams (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE games ADD CONSTRAINT `FK_FF232B319C4C13F6` FOREIGN KEY (home_team_id) REFERENCES teams (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE predictions ADD CONSTRAINT `FK_8E87BCE6A76ED395` FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE predictions ADD CONSTRAINT `FK_8E87BCE6E48FD905` FOREIGN KEY (game_id) REFERENCES games (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL, CHANGE role_id role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT `FK_1483A5E9D60322AC` FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_1483A5E9D60322AC ON users (role_id)');
    }
}
