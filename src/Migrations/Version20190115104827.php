<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190115104827 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(50) NOT NULL, keywords VARCHAR(255) NOT NULL, firm_name VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, phone_number VARCHAR(15) NOT NULL, facebook VARCHAR(100) NOT NULL, twitter VARCHAR(100) NOT NULL, google_plus VARCHAR(100) NOT NULL, youtube VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles VARCHAR(50) DEFAULT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(30) DEFAULT NULL, status VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image CHANGE image_source image_source VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE saved_date saved_date VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE setting CHANGE email email VARCHAR(15) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE image CHANGE image_source image_source VARCHAR(255) DEFAULT \'sample.png\' NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE product CHANGE saved_date saved_date VARCHAR(15) DEFAULT \'\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE setting CHANGE email email VARCHAR(50) DEFAULT \'\' NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
