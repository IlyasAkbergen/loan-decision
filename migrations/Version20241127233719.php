<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241127233719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id UUID NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, ssn VARCHAR(255) NOT NULL, address JSON NOT NULL, credit_rating INT NOT NULL, phone_number VARCHAR(255) NOT NULL, monthly_income DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74404556B01BC5B ON client (phone_number)');
        $this->addSql('CREATE TABLE product (id UUID NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, term_months INT NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, sum DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE product');
    }
}
