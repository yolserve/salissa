<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250609120422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE donation ADD campaign_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donation ADD CONSTRAINT FK_31E581A0F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_31E581A0F639F774 ON donation (campaign_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD phone_number VARCHAR(50) DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0F639F774
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_31E581A0F639F774 ON donation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE donation DROP campaign_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment DROP phone_number
        SQL);
    }
}
