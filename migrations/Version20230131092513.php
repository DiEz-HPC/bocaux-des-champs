<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131092513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bolt_password_request');
        $this->addSql('ALTER TABLE bolt_field_translation CHANGE value value JSON NOT NULL');
        $this->addSql('ALTER TABLE bolt_ordered ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bolt_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT 0 NOT NULL, INDEX IDX_AFC1BF6FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bolt_password_request ADD CONSTRAINT FK_AFC1BF6FA76ED395 FOREIGN KEY (user_id) REFERENCES bolt_user (id) ON UPDATE CASCADE ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE bolt_field_translation CHANGE value value JSON NOT NULL');
        $this->addSql('ALTER TABLE bolt_ordered DROP created_at');
    }
}
