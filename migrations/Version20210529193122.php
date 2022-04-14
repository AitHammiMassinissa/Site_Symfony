<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210529193122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_tableformation (user_id INT NOT NULL, tableformation_id INT NOT NULL, INDEX IDX_95B89556A76ED395 (user_id), INDEX IDX_95B895563FE3696D (tableformation_id), PRIMARY KEY(user_id, tableformation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_tableformation ADD CONSTRAINT FK_95B89556A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tableformation ADD CONSTRAINT FK_95B895563FE3696D FOREIGN KEY (tableformation_id) REFERENCES tableformation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_tableformation');
    }
}
