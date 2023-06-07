<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605210557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alpha3_code VARCHAR(3) NOT NULL, flag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE credit (id INT AUTO_INCREMENT NOT NULL, production_id INT NOT NULL, person_id INT NOT NULL, type VARCHAR(50) NOT NULL, role VARCHAR(255) DEFAULT NULL, INDEX IDX_1CC16EFE8F93B6FC (production_id), INDEX IDX_1CC16EFE217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, release_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', duration INT NOT NULL, tagline VARCHAR(255) DEFAULT NULL, synopsis LONGTEXT NOT NULL, rating DOUBLE PRECISION DEFAULT NULL, poster VARCHAR(255) NOT NULL, backdrop VARCHAR(255) NOT NULL, trailer VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_tag (production_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_DCD9F2918F93B6FC (production_id), INDEX IDX_DCD9F291BAD26311 (tag_id), PRIMARY KEY(production_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE production_country (production_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_73E58B488F93B6FC (production_id), INDEX IDX_73E58B48F92F3E70 (country_id), PRIMARY KEY(production_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, birthdate DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', birthplace VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person_country (person_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_71ED7AEF217BBB47 (person_id), INDEX IDX_71ED7AEFF92F3E70 (country_id), PRIMARY KEY(person_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE8F93B6FC FOREIGN KEY (production_id) REFERENCES production (id)');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT FK_1CC16EFE217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE production_tag ADD CONSTRAINT FK_DCD9F2918F93B6FC FOREIGN KEY (production_id) REFERENCES production (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_tag ADD CONSTRAINT FK_DCD9F291BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_country ADD CONSTRAINT FK_73E58B488F93B6FC FOREIGN KEY (production_id) REFERENCES production (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE production_country ADD CONSTRAINT FK_73E58B48F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_country ADD CONSTRAINT FK_71ED7AEF217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person_country ADD CONSTRAINT FK_71ED7AEFF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE8F93B6FC');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY FK_1CC16EFE217BBB47');
        $this->addSql('ALTER TABLE production_tag DROP FOREIGN KEY FK_DCD9F2918F93B6FC');
        $this->addSql('ALTER TABLE production_tag DROP FOREIGN KEY FK_DCD9F291BAD26311');
        $this->addSql('ALTER TABLE production_country DROP FOREIGN KEY FK_73E58B488F93B6FC');
        $this->addSql('ALTER TABLE production_country DROP FOREIGN KEY FK_73E58B48F92F3E70');
        $this->addSql('ALTER TABLE person_country DROP FOREIGN KEY FK_71ED7AEF217BBB47');
        $this->addSql('ALTER TABLE person_country DROP FOREIGN KEY FK_71ED7AEFF92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE credit');
        $this->addSql('DROP TABLE production');
        $this->addSql('DROP TABLE production_tag');
        $this->addSql('DROP TABLE production_country');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE person_country');
        $this->addSql('DROP TABLE tag');
    }
}
