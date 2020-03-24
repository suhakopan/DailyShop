<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190118135418 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, subject VARCHAR(20) NOT NULL, company VARCHAR(20) DEFAULT NULL, message VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders CHANGE user_id user_id INT NOT NULL, CHANGE total total DOUBLE PRECISION NOT NULL, CHANGE tax tax DOUBLE PRECISION NOT NULL, CHANGE payment_type payment_type VARCHAR(50) NOT NULL, CHANGE note note VARCHAR(255) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE status status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(50) DEFAULT NULL, CHANGE status status VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE order_detail CHANGE order_id order_id INT NOT NULL, CHANGE product_id product_id INT NOT NULL, CHANGE quantity quantity INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE order_detail CHANGE order_id order_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL, CHANGE quantity quantity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders CHANGE user_id user_id INT DEFAULT NULL, CHANGE total total DOUBLE PRECISION DEFAULT NULL, CHANGE tax tax DOUBLE PRECISION DEFAULT NULL, CHANGE payment_type payment_type VARCHAR(50) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE note note VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE status status TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE product CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(50) DEFAULT \'ROLE_USER\' COLLATE utf8mb4_unicode_ci, CHANGE status status VARCHAR(10) DEFAULT \'false\' COLLATE utf8mb4_unicode_ci');
    }
}
