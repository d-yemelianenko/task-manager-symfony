<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521171445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE task (
                id INT AUTO_INCREMENT NOT NULL, 
                task_status_id INT DEFAULT NULL, 
                title VARCHAR(255) NOT NULL, 
                description LONGTEXT DEFAULT NULL, 
                due_date DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', 
                created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', 
                updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', 
                INDEX IDX_527EDB2514DDCDEC (task_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task_priority (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(50) NOT NULL, 
            level VARCHAR(255) NOT NULL, 
            UNIQUE INDEX UNIQ_2266366B5E237E06 (name), 
            UNIQUE INDEX UNIQ_2266366B9AEACC13 (level), 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE task_status (
                id INT AUTO_INCREMENT NOT NULL, 
                name VARCHAR(50) NOT NULL, 
                slug VARCHAR(50) NOT NULL, 
                UNIQUE INDEX UNIQ_40A9E1CF5E237E06 (name), 
                UNIQUE INDEX UNIQ_40A9E1CF989D9B62 (slug), 
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task ADD CONSTRAINT FK_527EDB2514DDCDEC FOREIGN KEY (task_status_id) REFERENCES task_status (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE task DROP FOREIGN KEY FK_527EDB2514DDCDEC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task_priority
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task_status
        SQL);
    }
}
