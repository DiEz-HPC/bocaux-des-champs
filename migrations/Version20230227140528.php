<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227140528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bolt_newsletter (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date_sent DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bolt_newsletter_newsletter_user (newsletter_id INT NOT NULL, newsletter_user_id INT NOT NULL, INDEX IDX_9747186422DB1917 (newsletter_id), INDEX IDX_97471864A8D470FA (newsletter_user_id), PRIMARY KEY(newsletter_id, newsletter_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bolt_newsletter_newsletter_user ADD CONSTRAINT FK_9747186422DB1917 FOREIGN KEY (newsletter_id) REFERENCES bolt_newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bolt_newsletter_newsletter_user ADD CONSTRAINT FK_97471864A8D470FA FOREIGN KEY (newsletter_user_id) REFERENCES bolt_newsletter_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bolt_field_translation CHANGE value value JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bolt_newsletter_newsletter_user DROP FOREIGN KEY FK_9747186422DB1917');
        $this->addSql('DROP TABLE bolt_newsletter');
        $this->addSql('DROP TABLE bolt_newsletter_newsletter_user');
        $this->addSql('ALTER TABLE bolt_field_translation CHANGE value value JSON NOT NULL');
    }
}
