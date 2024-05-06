<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506165506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_appsubfunction (profile_id INT NOT NULL, appsubfunction_id INT NOT NULL, INDEX IDX_6F2431A5CCFA12B8 (profile_id), INDEX IDX_6F2431A51DA99636 (appsubfunction_id), PRIMARY KEY(profile_id, appsubfunction_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_appsubfunction ADD CONSTRAINT FK_6F2431A5CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_appsubfunction ADD CONSTRAINT FK_6F2431A51DA99636 FOREIGN KEY (appsubfunction_id) REFERENCES appsubfunction (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_appsubfunction DROP FOREIGN KEY FK_6F2431A5CCFA12B8');
        $this->addSql('ALTER TABLE profile_appsubfunction DROP FOREIGN KEY FK_6F2431A51DA99636');
        $this->addSql('DROP TABLE profile_appsubfunction');
    }
}
