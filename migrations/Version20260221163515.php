<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260221163515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE name name VARCHAR(150) NOT NULL, CHANGE price price NUMERIC(8, 2) NOT NULL, CHANGE image_url image_url VARCHAR(255) DEFAULT NULL, CHANGE platform platform VARCHAR(100) DEFAULT NULL, CHANGE release_year release_year VARCHAR(4) DEFAULT NULL, CHANGE stock stock INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE name name VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE image_url image_url VARCHAR(255) NOT NULL, CHANGE release_year release_year DATE NOT NULL, CHANGE platform platform VARCHAR(255) NOT NULL, CHANGE stock stock INT NOT NULL');
    }
}
