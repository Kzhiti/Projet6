<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507110144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks CHANGE description description VARCHAR(5000) NOT NULL');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA6432B281BE2E');
        $this->addSql('DROP INDEX IDX_29AA6432B281BE2E ON videos');
        $this->addSql('ALTER TABLE videos ADD trick_parent_id INT DEFAULT NULL, DROP trick_id');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA643229C1B7E9 FOREIGN KEY (trick_parent_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_29AA643229C1B7E9 ON videos (trick_parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tricks CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE videos DROP FOREIGN KEY FK_29AA643229C1B7E9');
        $this->addSql('DROP INDEX IDX_29AA643229C1B7E9 ON videos');
        $this->addSql('ALTER TABLE videos ADD trick_id INT NOT NULL, DROP trick_parent_id');
        $this->addSql('ALTER TABLE videos ADD CONSTRAINT FK_29AA6432B281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_29AA6432B281BE2E ON videos (trick_id)');
    }
}
