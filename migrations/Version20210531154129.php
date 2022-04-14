<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531154129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_payement ADD user_id_id INT DEFAULT NULL, ADD formation_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_payement ADD CONSTRAINT FK_642A601F9D86650F FOREIGN KEY (user_id_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commande_payement ADD CONSTRAINT FK_642A601F9CF0022 FOREIGN KEY (formation_id_id) REFERENCES tableformation (id)');
        $this->addSql('CREATE INDEX IDX_642A601F9D86650F ON commande_payement (user_id_id)');
        $this->addSql('CREATE INDEX IDX_642A601F9CF0022 ON commande_payement (formation_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_payement DROP FOREIGN KEY FK_642A601F9D86650F');
        $this->addSql('ALTER TABLE commande_payement DROP FOREIGN KEY FK_642A601F9CF0022');
        $this->addSql('DROP INDEX IDX_642A601F9D86650F ON commande_payement');
        $this->addSql('DROP INDEX IDX_642A601F9CF0022 ON commande_payement');
        $this->addSql('ALTER TABLE commande_payement DROP user_id_id, DROP formation_id_id');
    }
}
