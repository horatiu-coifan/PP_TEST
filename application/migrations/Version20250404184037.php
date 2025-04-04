<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404184037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE clients ADD CONSTRAINT FK_C82E7441E8B2E5 FOREIGN KEY (credentials_id) REFERENCES login (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients ADD CONSTRAINT FK_C82E7485E73F45 FOREIGN KEY (county_id) REFERENCES county (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_C82E7441E8B2E5 ON clients (credentials_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C82E7485E73F45 ON clients (county_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transactions DROP deleted
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE clients DROP FOREIGN KEY FK_C82E7441E8B2E5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE clients DROP FOREIGN KEY FK_C82E7485E73F45
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_C82E7441E8B2E5 ON clients
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C82E7485E73F45 ON clients
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transactions ADD deleted TINYINT(1) DEFAULT NULL
        SQL);
    }
}
