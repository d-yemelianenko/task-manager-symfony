<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250914214729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
        CREATE TABLE user (
            id INT AUTO_INCREMENT NOT NULL, 
            email VARCHAR(180) NOT NULL, 
            roles JSON NOT NULL, 
            password VARCHAR(255) NOT NULL, 
            is_verified TINYINT(1) NOT NULL, 
            UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
    SQL);

        $this->addSql(<<<'SQL'
        CREATE TABLE task_status (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(50) NOT NULL, 
            slug VARCHAR(50) NOT NULL, 
            UNIQUE INDEX UNIQ_40A9E1CF5E237E06 (name), 
            UNIQUE INDEX UNIQ_40A9E1CF989D9B62 (slug), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
    SQL);

        $this->addSql(<<<'SQL'
        CREATE TABLE task_priority (
            id INT AUTO_INCREMENT NOT NULL, 
            name VARCHAR(50) NOT NULL, 
            level INT NOT NULL, 
            UNIQUE INDEX UNIQ_2266366B5E237E06 (name), 
            UNIQUE INDEX UNIQ_2266366B9AEACC13 (level), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
    SQL);

        $this->addSql(<<<'SQL'
        CREATE TABLE task (
            id INT AUTO_INCREMENT NOT NULL, 
            author_id INT NOT NULL, 
            task_status_id INT DEFAULT NULL, 
            task_priority_id INT DEFAULT NULL, 
            title VARCHAR(255) NOT NULL, 
            description LONGTEXT DEFAULT NULL, 
            due_date DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', 
            created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', 
            updated_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', 
            INDEX IDX_527EDB25F675F31B (author_id), 
            INDEX IDX_527EDB2514DDCDEC (task_status_id), 
            INDEX IDX_527EDB25D3F9BD (task_priority_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
    SQL);

        $this->addSql(<<<'SQL'
        ALTER TABLE task 
        ADD CONSTRAINT FK_527EDB25F675F31B FOREIGN KEY (author_id) REFERENCES user (id)
    SQL);

        $this->addSql(<<<'SQL'
        ALTER TABLE task 
        ADD CONSTRAINT FK_527EDB2514DDCDEC FOREIGN KEY (task_status_id) REFERENCES task_status (id)
    SQL);

        $this->addSql(<<<'SQL'
        ALTER TABLE task 
        ADD CONSTRAINT FK_527EDB25D3F9BD FOREIGN KEY (task_priority_id) REFERENCES task_priority (id)
    SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
        ALTER TABLE task DROP FOREIGN KEY FK_527EDB25D3F9BD
    SQL);
        $this->addSql(<<<'SQL'
        ALTER TABLE task DROP FOREIGN KEY FK_527EDB2514DDCDEC
    SQL);
        $this->addSql(<<<'SQL'
        ALTER TABLE task DROP FOREIGN KEY FK_527EDB25F675F31B
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
        $this->addSql(<<<'SQL'
        DROP TABLE user
    SQL);
    }
}
