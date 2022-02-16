<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211206124855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adventure (id INT AUTO_INCREMENT NOT NULL, destination_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_9E858E0F816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, fullname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, trip_id INT DEFAULT NULL, adventure_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_42C8495519EB6921 (client_id), INDEX IDX_42C84955A5BC2E0E (trip_id), INDEX IDX_42C8495555CF40F9 (adventure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, hotel_id INT DEFAULT NULL, destination_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date DATE NOT NULL, duree VARCHAR(255) NOT NULL, prix VARCHAR(255) NOT NULL, INDEX IDX_7656F53B3243BB18 (hotel_id), INDEX IDX_7656F53B816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adventure ADD CONSTRAINT FK_9E858E0F816C6140 FOREIGN KEY (destination_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495555CF40F9 FOREIGN KEY (adventure_id) REFERENCES adventure (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B816C6140 FOREIGN KEY (destination_id) REFERENCES place (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495555CF40F9');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B3243BB18');
        $this->addSql('ALTER TABLE adventure DROP FOREIGN KEY FK_9E858E0F816C6140');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B816C6140');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A5BC2E0E');
        $this->addSql('DROP TABLE adventure');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE trip');
    }
}
