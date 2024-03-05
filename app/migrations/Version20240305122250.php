<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305122250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE training_training_category (training_id INT NOT NULL, training_category_id INT NOT NULL, INDEX IDX_6F265B11BEFD98D1 (training_id), INDEX IDX_6F265B11B62DE735 (training_category_id), PRIMARY KEY(training_id, training_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training_training_category ADD CONSTRAINT FK_6F265B11BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_training_category ADD CONSTRAINT FK_6F265B11B62DE735 FOREIGN KEY (training_category_id) REFERENCES training_category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE training_training_category DROP FOREIGN KEY FK_6F265B11BEFD98D1');
        $this->addSql('ALTER TABLE training_training_category DROP FOREIGN KEY FK_6F265B11B62DE735');
        $this->addSql('DROP TABLE training_training_category');
    }
}
