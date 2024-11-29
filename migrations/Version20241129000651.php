<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129000651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loan (id UUID NOT NULL, term_months INT NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, sum DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, client_id UUID NOT NULL, product_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C5D30D0319EB6921 ON loan (client_id)');
        $this->addSql('CREATE INDEX IDX_C5D30D034584665A ON loan (product_id)');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D0319EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D034584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loan DROP CONSTRAINT FK_C5D30D0319EB6921');
        $this->addSql('ALTER TABLE loan DROP CONSTRAINT FK_C5D30D034584665A');
        $this->addSql('DROP TABLE loan');
    }
}
