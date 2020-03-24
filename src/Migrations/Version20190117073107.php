<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190117073107 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP address, DROP city, DROP phone, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD address VARCHAR(255) NOT NULL, ADD phone VARCHAR(15) NOT NULL, ADD city VARCHAR(25) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders ADD address VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD city VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD phone VARCHAR(15) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE user DROP address, DROP phone, DROP city');
    }
}
