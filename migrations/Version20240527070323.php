<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527070323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ajout d\'un champ imageName dans la table Recipe';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX title ON recipes');
        $this->addSql('ALTER TABLE recipes ADD image_name VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipes DROP image_name');
        $this->addSql('CREATE UNIQUE INDEX title ON recipes (title)');
    }
}
