<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227220212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complaints (id INT AUTO_INCREMENT NOT NULL, complaint_from VARCHAR(255) NOT NULL, complaint_against VARCHAR(255) NOT NULL, complaint_title VARCHAR(255) NOT NULL, complaint_date DATETIME NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE custom_questions (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, is_required VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employees_asset_setup (id INT AUTO_INCREMENT NOT NULL, employee VARCHAR(255) NOT NULL, employee_name VARCHAR(255) NOT NULL, amount INT NOT NULL, purchase_date DATETIME NOT NULL, supported_date DATETIME NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE holidays (id INT AUTO_INCREMENT NOT NULL, occasion VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manage_leave (id INT AUTO_INCREMENT NOT NULL, employee VARCHAR(255) NOT NULL, leave_type VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, leave_reason VARCHAR(255) NOT NULL, remark VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resignation (id INT AUTO_INCREMENT NOT NULL, employee VARCHAR(255) NOT NULL, notice_date DATETIME NOT NULL, resignation_date DATETIME NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE support_system (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, subject VARCHAR(255) NOT NULL, support_for_user VARCHAR(255) NOT NULL, priority TINYTEXT NOT NULL, status TINYTEXT NOT NULL, end_date DATETIME NOT NULL, description VARCHAR(1000) NOT NULL, image VARCHAR(100) NOT NULL, INDEX IDX_41B7F17BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, employee VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, purpose_of_trip VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_image (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, image_url LONGTEXT DEFAULT NULL, INDEX IDX_27FFFF07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, bio LONGTEXT DEFAULT NULL, mobile_number TINYTEXT DEFAULT NULL, country LONGTEXT DEFAULT NULL, company_name TINYTEXT DEFAULT NULL, company_website TINYTEXT DEFAULT NULL, facebook TINYTEXT DEFAULT NULL, twitter TINYTEXT DEFAULT NULL, instagram TINYTEXT DEFAULT NULL, linkedin TINYTEXT DEFAULT NULL, skype TINYTEXT DEFAULT NULL, github TINYTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_D95AB405A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warning (id INT AUTO_INCREMENT NOT NULL, warning_by VARCHAR(255) NOT NULL, warning_to VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, warning_date DATETIME NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE webhook (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, module VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, method VARCHAR(255) NOT NULL, INDEX IDX_8A741756A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zoom (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, project VARCHAR(255) NOT NULL, meeting_time DATETIME NOT NULL, duration INT NOT NULL, meeting_url VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_B72B7974A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE support_system ADD CONSTRAINT FK_41B7F17BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE webhook ADD CONSTRAINT FK_8A741756A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE zoom ADD CONSTRAINT FK_B72B7974A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD profile_id INT DEFAULT NULL, ADD parent_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES user_profile (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D526A7D3 FOREIGN KEY (parent_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON user (profile_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D526A7D3 ON user (parent_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE support_system DROP FOREIGN KEY FK_41B7F17BA76ED395');
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF07A76ED395');
        $this->addSql('ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB405A76ED395');
        $this->addSql('ALTER TABLE webhook DROP FOREIGN KEY FK_8A741756A76ED395');
        $this->addSql('ALTER TABLE zoom DROP FOREIGN KEY FK_B72B7974A76ED395');
        $this->addSql('DROP TABLE complaints');
        $this->addSql('DROP TABLE custom_questions');
        $this->addSql('DROP TABLE employees_asset_setup');
        $this->addSql('DROP TABLE holidays');
        $this->addSql('DROP TABLE manage_leave');
        $this->addSql('DROP TABLE resignation');
        $this->addSql('DROP TABLE support_system');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE user_image');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('DROP TABLE warning');
        $this->addSql('DROP TABLE webhook');
        $this->addSql('DROP TABLE zoom');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D526A7D3');
        $this->addSql('DROP INDEX UNIQ_8D93D649CCFA12B8 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649D526A7D3 ON user');
        $this->addSql('ALTER TABLE user DROP profile_id, DROP parent_user_id');
    }
}
