<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230608182421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE8F93B6FC');
        $this->addSql('CREATE TABLE production (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, release_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration INT NOT NULL, tagline VARCHAR(255) DEFAULT NULL, synopsis LONGTEXT NOT NULL, rating DOUBLE PRECISION DEFAULT NULL, poster VARCHAR(255) NOT NULL, backdrop VARCHAR(255) NOT NULL, trailer VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_tag (production_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_A80B75A9ECC6147F (production_id), INDEX IDX_A80B75A9BAD26311 (tag_id), PRIMARY KEY(production_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_country (production_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_466644BBECC6147F (production_id), INDEX IDX_466644BBF92F3E70 (country_id), PRIMARY KEY(production_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE production_tag ADD CONSTRAINT FK_A80B75A9ECC6147F FOREIGN KEY (production_id) REFERENCES production (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_tag ADD CONSTRAINT FK_A80B75A9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_country ADD CONSTRAINT FK_466644BBECC6147F FOREIGN KEY (production_id) REFERENCES production (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_country ADD CONSTRAINT FK_466644BBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_tag DROP FOREIGN KEY FK_DCD9F2918F93B6FC');
        $this->addSql('ALTER TABLE movie_tag DROP FOREIGN KEY FK_DCD9F291BAD26311');
        $this->addSql('ALTER TABLE movie_country DROP FOREIGN KEY FK_73E58B488F93B6FC');
        $this->addSql('ALTER TABLE movie_country DROP FOREIGN KEY FK_73E58B48F92F3E70');
        $this->addSql('DROP TABLE movie_tag');
        $this->addSql('DROP TABLE movie_country');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP INDEX IDX_1CC16EFE8F93B6FC ON credit');
        $this->addSql('ALTER TABLE credit CHANGE movie_id production_id INT NOT NULL');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFEECC6147F FOREIGN KEY (production_id) REFERENCES production (id)');
        $this->addSql('CREATE INDEX IDX_1CC16EFEECC6147F ON credit (production_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFEECC6147F');
        $this->addSql('CREATE TABLE movie_tag (movie_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_DCD9F2918F93B6FC (movie_id), INDEX IDX_DCD9F291BAD26311 (tag_id), PRIMARY KEY(movie_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE movie_country (movie_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_73E58B48F92F3E70 (country_id), INDEX IDX_73E58B488F93B6FC (movie_id), PRIMARY KEY(movie_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, type VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, release_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration INT NOT NULL, tagline VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, synopsis LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, rating DOUBLE PRECISION DEFAULT NULL, poster VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, backdrop VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, trailer VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE movie_tag ADD CONSTRAINT FK_DCD9F2918F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_tag ADD CONSTRAINT FK_DCD9F291BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_country ADD CONSTRAINT FK_73E58B488F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_country ADD CONSTRAINT FK_73E58B48F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_tag DROP FOREIGN KEY FK_A80B75A9ECC6147F');
        $this->addSql('ALTER TABLE production_tag DROP FOREIGN KEY FK_A80B75A9BAD26311');
        $this->addSql('ALTER TABLE production_country DROP FOREIGN KEY FK_466644BBECC6147F');
        $this->addSql('ALTER TABLE production_country DROP FOREIGN KEY FK_466644BBF92F3E70');
        $this->addSql('DROP TABLE production');
        $this->addSql('DROP TABLE production_tag');
        $this->addSql('DROP TABLE production_country');
        $this->addSql('DROP INDEX IDX_1CC16EFEECC6147F ON credit');
        $this->addSql('ALTER TABLE credit CHANGE production_id movie_id INT NOT NULL');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
        $this->addSql('CREATE INDEX IDX_1CC16EFE8F93B6FC ON credit (movie_id)');
    }
}
