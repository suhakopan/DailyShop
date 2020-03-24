<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190117071559 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, order_id INT NOT NULL, product_id INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, tax DOUBLE PRECISION NOT NULL, payment_type VARCHAR(50) NOT NULL, note VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(50) NOT NULL, phone VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, keywords VARCHAR(255) NOT NULL, firm_name VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, phone_number VARCHAR(15) NOT NULL, facebook VARCHAR(100) NOT NULL, twitter VARCHAR(100) NOT NULL, google_plus VARCHAR(100) NOT NULL, youtube VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE setting CHANGE email email VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE settings');
        $this->addSql('ALTER TABLE setting CHANGE email email VARCHAR(50) DEFAULT \'\' NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
