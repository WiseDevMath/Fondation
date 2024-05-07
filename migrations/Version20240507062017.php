<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507062017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appauthorization (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, appsubfunction_id INT NOT NULL, level VARCHAR(50) NOT NULL, INDEX IDX_E2B8F3C7CCFA12B8 (profile_id), INDEX IDX_E2B8F3C71DA99636 (appsubfunction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appauthorization ADD CONSTRAINT FK_E2B8F3C7CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE appauthorization ADD CONSTRAINT FK_E2B8F3C71DA99636 FOREIGN KEY (appsubfunction_id) REFERENCES appsubfunction (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appauthorization DROP FOREIGN KEY FK_E2B8F3C7CCFA12B8');
        $this->addSql('ALTER TABLE appauthorization DROP FOREIGN KEY FK_E2B8F3C71DA99636');
        $this->addSql('DROP TABLE appauthorization');
    }
}
