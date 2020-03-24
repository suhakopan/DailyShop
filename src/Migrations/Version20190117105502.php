<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190117105502 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders ADD status TINYINT(1) NOT NULL, CHANGE payment_type payment_type VARCHAR(50) NOT NULL, CHANGE note note VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE price price DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders DROP status, CHANGE payment_type payment_type VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE note note VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE created_at created_at DATETIME DEFAULT \'0000-00-00 00:00:00\'');
        $this->addSql('ALTER TABLE product CHANGE price price DOUBLE PRECISION DEFAULT \'0.00\' NOT NULL');
    }
}
