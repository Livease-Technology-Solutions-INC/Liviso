<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231213170106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_profile ADD mobile_number TINYTEXT DEFAULT NULL, ADD country LONGTEXT DEFAULT NULL, CHANGE company_website company_website TINYTEXT DEFAULT NULL, CHANGE facebook facebook TINYTEXT DEFAULT NULL, CHANGE twitter twitter TINYTEXT DEFAULT NULL, CHANGE instagram instagram TINYTEXT DEFAULT NULL, CHANGE linkedin linkedin TINYTEXT DEFAULT NULL, CHANGE skype skype TINYTEXT DEFAULT NULL, CHANGE github github TINYTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_profile DROP mobile_number, DROP country, CHANGE company_website company_website TINYTEXT NOT NULL, CHANGE facebook facebook TINYTEXT NOT NULL, CHANGE twitter twitter TINYTEXT NOT NULL, CHANGE instagram instagram TINYTEXT NOT NULL, CHANGE linkedin linkedin TINYTEXT NOT NULL, CHANGE skype skype TINYTEXT NOT NULL, CHANGE github github TINYTEXT NOT NULL');
    }
}
