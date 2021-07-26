<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726122703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE widget (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE widget_establishment (widget_id INT NOT NULL, establishment_id INT NOT NULL, INDEX IDX_41B4328DFBE885E2 (widget_id), INDEX IDX_41B4328D8565851 (establishment_id), PRIMARY KEY(widget_id, establishment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE widget_establishment ADD CONSTRAINT FK_41B4328DFBE885E2 FOREIGN KEY (widget_id) REFERENCES widget (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE widget_establishment ADD CONSTRAINT FK_41B4328D8565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE widget_establishment DROP FOREIGN KEY FK_41B4328DFBE885E2');
        $this->addSql('DROP TABLE widget');
        $this->addSql('DROP TABLE widget_establishment');
    }
}
