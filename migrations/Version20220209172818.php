<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220209172818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create ApiKey schema.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE api_key (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(180) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_C912ED9D8A90ABA9 (`key`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE api_key');
    }
}
