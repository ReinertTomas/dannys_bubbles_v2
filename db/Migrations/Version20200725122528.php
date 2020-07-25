<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200725122528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Config files show, business, personal';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE config DROP FOREIGN KEY FK_D48A2F7C887793B6');
        $this->addSql('DROP INDEX UNIQ_D48A2F7C887793B6 ON config');
        $this->addSql('ALTER TABLE config ADD document_business_id INT DEFAULT NULL, ADD document_personal_id INT DEFAULT NULL, CHANGE condition_id document_show_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE config ADD CONSTRAINT FK_D48A2F7C74AE5AB8 FOREIGN KEY (document_show_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE config ADD CONSTRAINT FK_D48A2F7C2A34833D FOREIGN KEY (document_business_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE config ADD CONSTRAINT FK_D48A2F7CDFEA3E23 FOREIGN KEY (document_personal_id) REFERENCES document (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D48A2F7C74AE5AB8 ON config (document_show_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D48A2F7C2A34833D ON config (document_business_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D48A2F7CDFEA3E23 ON config (document_personal_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE config DROP FOREIGN KEY FK_D48A2F7C74AE5AB8');
        $this->addSql('ALTER TABLE config DROP FOREIGN KEY FK_D48A2F7C2A34833D');
        $this->addSql('ALTER TABLE config DROP FOREIGN KEY FK_D48A2F7CDFEA3E23');
        $this->addSql('DROP INDEX UNIQ_D48A2F7C74AE5AB8 ON config');
        $this->addSql('DROP INDEX UNIQ_D48A2F7C2A34833D ON config');
        $this->addSql('DROP INDEX UNIQ_D48A2F7CDFEA3E23 ON config');
        $this->addSql('ALTER TABLE config ADD condition_id INT DEFAULT NULL, DROP document_show_id, DROP document_business_id, DROP document_personal_id');
        $this->addSql('ALTER TABLE config ADD CONSTRAINT FK_D48A2F7C887793B6 FOREIGN KEY (condition_id) REFERENCES document (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D48A2F7C887793B6 ON config (condition_id)');
    }
}
