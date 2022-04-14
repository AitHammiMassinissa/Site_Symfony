<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529200706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD date_inscription_id INT DEFAULT NULL, ADD id_formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939852D79ED6 FOREIGN KEY (date_inscription_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939871C15D5C FOREIGN KEY (id_formation_id) REFERENCES tableformation (id)');
        $this->addSql('CREATE INDEX IDX_F529939852D79ED6 ON `order` (date_inscription_id)');
        $this->addSql('CREATE INDEX IDX_F529939871C15D5C ON `order` (id_formation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939852D79ED6');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939871C15D5C');
        $this->addSql('DROP INDEX IDX_F529939852D79ED6 ON `order`');
        $this->addSql('DROP INDEX IDX_F529939871C15D5C ON `order`');
        $this->addSql('ALTER TABLE `order` DROP date_inscription_id, DROP id_formation_id');
    }
}
