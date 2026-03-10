<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260302132757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY `FK_BA388B7A76ED395`');
        $this->addSql('DROP INDEX IDX_BA388B7A76ED395 ON cart');
        $this->addSql('ALTER TABLE cart DROP checked_out_at, DROP created_at, DROP updated_at, DROP user_id, CHANGE checked_out checked_out TINYINT NOT NULL');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY `FK_F0FE25271AD5CDBF`');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY `FK_F0FE25274584665A`');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD checked_out_at DATETIME DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD user_id INT DEFAULT NULL, CHANGE checked_out checked_out TINYINT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT `FK_F0FE25271AD5CDBF` FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT `FK_F0FE25274584665A` FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
