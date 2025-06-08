<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250608082432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE beneficiary ADD user_account_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE beneficiary ADD CONSTRAINT FK_7ABF446A3C0C9956 FOREIGN KEY (user_account_id) REFERENCES user_account (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_7ABF446A3C0C9956 ON beneficiary (user_account_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_account ADD is_verified TINYINT(1) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE beneficiary DROP FOREIGN KEY FK_7ABF446A3C0C9956
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_7ABF446A3C0C9956 ON beneficiary
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE beneficiary DROP user_account_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_account DROP is_verified
        SQL);
    }
}
