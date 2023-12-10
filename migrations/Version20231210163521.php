<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210163521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP gio, DROP company_name, DROP company_website, DROP facebook, DROP twitter, DROP linkedin, DROP skype, DROP github, DROP profile_picture');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD gio VARCHAR(255) NOT NULL, ADD company_name VARCHAR(255) NOT NULL, ADD company_website VARCHAR(255) NOT NULL, ADD facebook VARCHAR(255) NOT NULL, ADD twitter VARCHAR(255) NOT NULL, ADD linkedin VARCHAR(255) NOT NULL, ADD skype VARCHAR(255) NOT NULL, ADD github VARCHAR(255) NOT NULL, ADD profile_picture VARCHAR(255) NOT NULL');
    }
}
