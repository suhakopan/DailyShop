<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190111151001 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, gender_no INT NOT NULL, name VARCHAR(50) NOT NULL, created_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genders CHANGE name name VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE name name VARCHAR(20) NOT NULL, CHANGE gender gender TINYINT(1) NOT NULL, CHANGE birth_date birth_date VARCHAR(15) NOT NULL, CHANGE address address VARCHAR(180) NOT NULL, CHANGE authority authority TINYINT(1) NOT NULL, CHANGE phone_number phone_number VARCHAR(15) NOT NULL, CHANGE saved_date saved_date DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE category');
        $this->addSql('ALTER TABLE genders CHANGE name name VARCHAR(15) DEFAULT \'\' NOT NULL COLLATE utf8mb4_general_ci');
        $this->addSql('ALTER TABLE users CHANGE name name VARCHAR(20) DEFAULT \'\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE gender gender TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE birth_date birth_date VARCHAR(15) DEFAULT \'\' COLLATE utf8mb4_unicode_ci, CHANGE address address VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE authority authority TINYINT(1) DEFAULT \'0\', CHANGE phone_number phone_number VARCHAR(15) DEFAULT \'\' NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE saved_date saved_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
