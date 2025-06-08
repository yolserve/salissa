<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250608123636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign ADD beneficiary_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DDECCAAFA0 FOREIGN KEY (beneficiary_id) REFERENCES beneficiary (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_1F1512DDECCAAFA0 ON campaign (beneficiary_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign DROP FOREIGN KEY FK_1F1512DDECCAAFA0
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_1F1512DDECCAAFA0 ON campaign
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign DROP beneficiary_id
        SQL);
    }
}
