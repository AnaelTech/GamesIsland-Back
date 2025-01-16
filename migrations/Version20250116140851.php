<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116140851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish_list DROP INDEX IDX_5B8739BDA76ED395, ADD UNIQUE INDEX UNIQ_5B8739BDA76ED395 (user_id)');
        $this->addSql('ALTER TABLE wish_list DROP is_like, CHANGE user_id user_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish_list DROP INDEX UNIQ_5B8739BDA76ED395, ADD INDEX IDX_5B8739BDA76ED395 (user_id)');
        $this->addSql('ALTER TABLE wish_list ADD is_like TINYINT(1) DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL');
    }
}
