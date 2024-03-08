<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307154338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_student_event DROP FOREIGN KEY FK_9920A12BCB944F1A');
        $this->addSql('DROP INDEX IDX_9920A12BCB944F1A ON quiz_student_event');
        $this->addSql('ALTER TABLE quiz_student_event CHANGE student_id quiz_result_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz_student_event ADD CONSTRAINT FK_9920A12B1C7C7A5 FOREIGN KEY (quiz_result_id) REFERENCES quiz_student_result (id)');
        $this->addSql('CREATE INDEX IDX_9920A12B1C7C7A5 ON quiz_student_event (quiz_result_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_student_event DROP FOREIGN KEY FK_9920A12B1C7C7A5');
        $this->addSql('DROP INDEX IDX_9920A12B1C7C7A5 ON quiz_student_event');
        $this->addSql('ALTER TABLE quiz_student_event CHANGE quiz_result_id student_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz_student_event ADD CONSTRAINT FK_9920A12BCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('CREATE INDEX IDX_9920A12BCB944F1A ON quiz_student_event (student_id)');
    }
}
