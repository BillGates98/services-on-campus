<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190227181624 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produit DROP operations_id');
        //$this->addSql('ALTER TABLE numeros ADD CONSTRAINT FK_C4C2BA919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        //$this->addSql('CREATE INDEX IDX_C4C2BA919EB6921 ON numeros (client_id)');
        $this->addSql('ALTER TABLE operations DROP INDEX UNIQ_28145348F347EFB, ADD INDEX IDX_28145348F347EFB (produit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE numeros DROP FOREIGN KEY FK_C4C2BA919EB6921');
        $this->addSql('DROP INDEX IDX_C4C2BA919EB6921 ON numeros');
        $this->addSql('ALTER TABLE operations DROP INDEX IDX_28145348F347EFB, ADD UNIQUE INDEX UNIQ_28145348F347EFB (produit_id)');
        $this->addSql('ALTER TABLE produit ADD operations_id INT NOT NULL');
    }
}
