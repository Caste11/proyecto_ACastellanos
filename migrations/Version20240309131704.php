<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240309131704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indicencia ADD user_id INT DEFAULT NULL, ADD cliente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE indicencia ADD CONSTRAINT FK_D0064B2DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE indicencia ADD CONSTRAINT FK_D0064B2DDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('CREATE INDEX IDX_D0064B2DA76ED395 ON indicencia (user_id)');
        $this->addSql('CREATE INDEX IDX_D0064B2DDE734E51 ON indicencia (cliente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indicencia DROP FOREIGN KEY FK_D0064B2DA76ED395');
        $this->addSql('ALTER TABLE indicencia DROP FOREIGN KEY FK_D0064B2DDE734E51');
        $this->addSql('DROP INDEX IDX_D0064B2DA76ED395 ON indicencia');
        $this->addSql('DROP INDEX IDX_D0064B2DDE734E51 ON indicencia');
        $this->addSql('ALTER TABLE indicencia DROP user_id, DROP cliente_id');
    }
}
