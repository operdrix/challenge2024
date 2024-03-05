<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305095751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_grade (student_id INT NOT NULL, grade_id INT NOT NULL, INDEX IDX_D16DD7A9CB944F1A (student_id), INDEX IDX_D16DD7A9FE19A1A8 (grade_id), PRIMARY KEY(student_id, grade_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_grade ADD CONSTRAINT FK_D16DD7A9CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_grade ADD CONSTRAINT FK_D16DD7A9FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student ADD address VARCHAR(255) DEFAULT NULL, ADD photo_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student_grade DROP FOREIGN KEY FK_D16DD7A9CB944F1A');
        $this->addSql('ALTER TABLE student_grade DROP FOREIGN KEY FK_D16DD7A9FE19A1A8');
        $this->addSql('DROP TABLE student_grade');
        $this->addSql('ALTER TABLE student DROP address, DROP photo_filename');
    }
}
