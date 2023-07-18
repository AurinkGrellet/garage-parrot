<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230718122345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, technical_informations LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, image VARCHAR(255) NOT NULL, year VARCHAR(4) NOT NULL, km NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE firstname firstname VARCHAR(180) NOT NULL, CHANGE lastname lastname VARCHAR(180) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car');
        $this->addSql('ALTER TABLE user CHANGE firstname firstname LONGTEXT NOT NULL, CHANGE lastname lastname LONGTEXT NOT NULL');
    }
}
