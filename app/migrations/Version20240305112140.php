<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305112140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_question_available_answer DROP FOREIGN KEY FK_D2E77847853CD175');
        $this->addSql('DROP INDEX IDX_D2E77847853CD175 ON quiz_question_available_answer');
        $this->addSql('ALTER TABLE quiz_question_available_answer ADD quiz_question_id INT DEFAULT NULL, DROP quiz_id');
        $this->addSql('ALTER TABLE quiz_question_available_answer ADD CONSTRAINT FK_D2E778473101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id)');
        $this->addSql('CREATE INDEX IDX_D2E778473101E51F ON quiz_question_available_answer (quiz_question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_question_available_answer DROP FOREIGN KEY FK_D2E778473101E51F');
        $this->addSql('DROP INDEX IDX_D2E778473101E51F ON quiz_question_available_answer');
        $this->addSql('ALTER TABLE quiz_question_available_answer ADD quiz_id INT NOT NULL, DROP quiz_question_id');
        $this->addSql('ALTER TABLE quiz_question_available_answer ADD CONSTRAINT FK_D2E77847853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE INDEX IDX_D2E77847853CD175 ON quiz_question_available_answer (quiz_id)');
    }
}
