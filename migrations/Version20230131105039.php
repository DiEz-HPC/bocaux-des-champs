<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131105039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bolt_order_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bolt_field_translation CHANGE value value JSON NOT NULL');
        $this->addSql('ALTER TABLE bolt_ordered ADD order_status_id INT DEFAULT NULL, DROP status');
        $this->addSql('ALTER TABLE bolt_ordered ADD CONSTRAINT FK_C87C01ACD7707B45 FOREIGN KEY (order_status_id) REFERENCES bolt_order_status (id)');
        $this->addSql('CREATE INDEX IDX_C87C01ACD7707B45 ON bolt_ordered (order_status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bolt_ordered DROP FOREIGN KEY FK_C87C01ACD7707B45');
        $this->addSql('DROP TABLE bolt_order_status');
        $this->addSql('ALTER TABLE bolt_field_translation CHANGE value value JSON NOT NULL');
        $this->addSql('DROP INDEX IDX_C87C01ACD7707B45 ON bolt_ordered');
        $this->addSql('ALTER TABLE bolt_ordered ADD status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP order_status_id');
    }
}
