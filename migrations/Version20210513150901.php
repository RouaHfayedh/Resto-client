<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513150901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE stripe_charge (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, amount_refunded INT NOT NULL, balance_transaction VARCHAR(255) DEFAULT NULL, captured TINYINT(1) DEFAULT NULL, created INT NOT NULL, currency VARCHAR(255) NOT NULL, customer VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, dispute VARCHAR(255) DEFAULT NULL, failure_code VARCHAR(255) DEFAULT NULL, failure_message VARCHAR(255) DEFAULT NULL, fraud_details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', invoice VARCHAR(255) DEFAULT NULL, livemode TINYINT(1) NOT NULL, metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', order_id VARCHAR(255) DEFAULT NULL, outcome LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', paid TINYINT(1) NOT NULL, receipt_email VARCHAR(255) DEFAULT NULL, receipt_number VARCHAR(255) DEFAULT NULL, refunded TINYINT(1) NOT NULL, shipping LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', source VARCHAR(255) DEFAULT NULL, statement_descriptor VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, stripe_id VARCHAR(255) NOT NULL, UNIQUE INDEX stripe_id_idx (stripe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3318B7E4006 FOREIGN KEY (booker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8B7E4006 FOREIGN KEY (booker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3318B7E4006');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8B7E4006');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AF675F31B');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('DROP TABLE stripe_charge');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE4F34D596');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4F34D596');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4F34D596');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
    }
}
