<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220114215055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE board (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_58562B47C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, node_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA7460D9FD7 (node_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE node (id INT AUTO_INCREMENT NOT NULL, board_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_857FE845E7EC5785 (board_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE board ADD CONSTRAINT FK_58562B47C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7460D9FD7 FOREIGN KEY (node_id) REFERENCES node (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE node ADD CONSTRAINT FK_857FE845E7EC5785 FOREIGN KEY (board_id) REFERENCES board (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE node DROP FOREIGN KEY FK_857FE845E7EC5785');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7460D9FD7');
        $this->addSql('ALTER TABLE board DROP FOREIGN KEY FK_58562B47C18272');
        $this->addSql('DROP TABLE board');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE node');
        $this->addSql('DROP TABLE projet');
    }
}
