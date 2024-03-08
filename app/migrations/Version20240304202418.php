<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304202418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, school_id INT NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_595AAE3441807E1D (teacher_id), INDEX IDX_595AAE34C32A47EE (school_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, grade_id INT DEFAULT NULL, training_id INT DEFAULT NULL, INDEX IDX_5E90F6D6FE19A1A8 (grade_id), INDEX IDX_5E90F6D6BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_student (inscription_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_9EF259DF5DAC5993 (inscription_id), INDEX IDX_9EF259DFCB944F1A (student_id), PRIMARY KEY(inscription_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progress (id INT AUTO_INCREMENT NOT NULL, inscription_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_2201F2465DAC5993 (inscription_id), INDEX IDX_2201F246CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE progress_training_block (progress_id INT NOT NULL, training_block_id INT NOT NULL, INDEX IDX_F957EBA743DB87C9 (progress_id), INDEX IDX_F957EBA7E88919B (training_block_id), PRIMARY KEY(progress_id, training_block_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, label VARCHAR(255) NOT NULL, is_opened TINYINT(1) NOT NULL, duration INT DEFAULT NULL, limit_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A412FA92BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, title VARCHAR(255) NOT NULL, point DOUBLE PRECISION NOT NULL, INDEX IDX_6033B00B853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question_available_answer (id INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, content VARCHAR(255) NOT NULL, is_correct TINYINT(1) NOT NULL, INDEX IDX_D2E77847853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question_student_answer (id INT AUTO_INCREMENT NOT NULL, quiz_question_id INT NOT NULL, student_id INT NOT NULL, content VARCHAR(255) NOT NULL, result DOUBLE PRECISION NOT NULL, INDEX IDX_EC222F6B3101E51F (quiz_question_id), INDEX IDX_EC222F6BCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_student_event (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, started_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', event_type VARCHAR(255) NOT NULL, INDEX IDX_9920A12BCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_student_result (id INT AUTO_INCREMENT NOT NULL, quiz_id INT DEFAULT NULL, student_id INT NOT NULL, inscription_id INT NOT NULL, quiz_title VARCHAR(255) NOT NULL, value DOUBLE PRECISION DEFAULT NULL, comment LONGTEXT DEFAULT NULL, is_validated TINYINT(1) NOT NULL, duration TIME DEFAULT NULL, INDEX IDX_F7C680B3853CD175 (quiz_id), INDEX IDX_F7C680B3CB944F1A (student_id), INDEX IDX_F7C680B35DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_BC91F416BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contact_name VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, logo_filename VARCHAR(255) DEFAULT NULL, INDEX IDX_F99EDABB41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, length INT NOT NULL, difficulty VARCHAR(255) NOT NULL, INDEX IDX_D5128A8F41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_block (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, quiz_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_6CC11D4FBEFD98D1 (training_id), INDEX IDX_6CC11D4F853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_block_resource (training_block_id INT NOT NULL, resource_id INT NOT NULL, INDEX IDX_61980244E88919B (training_block_id), INDEX IDX_6198024489329D25 (resource_id), PRIMARY KEY(training_block_id, resource_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_category (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_E1290A5641807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_objective (id INT AUTO_INCREMENT NOT NULL, training_id INT NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_D71A92F5BEFD98D1 (training_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_session (id INT AUTO_INCREMENT NOT NULL, inscription_id INT DEFAULT NULL, length INT NOT NULL, start_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_online TINYINT(1) NOT NULL, session_link VARCHAR(255) DEFAULT NULL, place VARCHAR(255) DEFAULT NULL, INDEX IDX_D7A45DA5DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_session_training_block (training_session_id INT NOT NULL, training_block_id INT NOT NULL, INDEX IDX_CCB7AB8FDB8156B9 (training_session_id), INDEX IDX_CCB7AB8FE88919B (training_block_id), PRIMARY KEY(training_session_id, training_block_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_session_student (id INT AUTO_INCREMENT NOT NULL, training_session_id INT DEFAULT NULL, student_id INT NOT NULL, is_present TINYINT(1) NOT NULL, INDEX IDX_10AC9452DB8156B9 (training_session_id), INDEX IDX_10AC9452CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3441807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34C32A47EE FOREIGN KEY (school_id) REFERENCES school (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6FE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE inscription_student ADD CONSTRAINT FK_9EF259DF5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_student ADD CONSTRAINT FK_9EF259DFCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F2465DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE progress_training_block ADD CONSTRAINT FK_F957EBA743DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_training_block ADD CONSTRAINT FK_F957EBA7E88919B FOREIGN KEY (training_block_id) REFERENCES training_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_question_available_answer ADD CONSTRAINT FK_D2E77847853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_question_student_answer ADD CONSTRAINT FK_EC222F6B3101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id)');
        $this->addSql('ALTER TABLE quiz_question_student_answer ADD CONSTRAINT FK_EC222F6BCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE quiz_student_event ADD CONSTRAINT FK_9920A12BCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE quiz_student_result ADD CONSTRAINT FK_F7C680B3853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz_student_result ADD CONSTRAINT FK_F7C680B3CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE quiz_student_result ADD CONSTRAINT FK_F7C680B35DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE school ADD CONSTRAINT FK_F99EDABB41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE training_block ADD CONSTRAINT FK_6CC11D4FBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE training_block ADD CONSTRAINT FK_6CC11D4F853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE training_block_resource ADD CONSTRAINT FK_61980244E88919B FOREIGN KEY (training_block_id) REFERENCES training_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_block_resource ADD CONSTRAINT FK_6198024489329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_category ADD CONSTRAINT FK_E1290A5641807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE training_objective ADD CONSTRAINT FK_D71A92F5BEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id)');
        $this->addSql('ALTER TABLE training_session ADD CONSTRAINT FK_D7A45DA5DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE training_session_training_block ADD CONSTRAINT FK_CCB7AB8FDB8156B9 FOREIGN KEY (training_session_id) REFERENCES training_session (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_session_training_block ADD CONSTRAINT FK_CCB7AB8FE88919B FOREIGN KEY (training_block_id) REFERENCES training_block (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_session_student ADD CONSTRAINT FK_10AC9452DB8156B9 FOREIGN KEY (training_session_id) REFERENCES training_session (id)');
        $this->addSql('ALTER TABLE training_session_student ADD CONSTRAINT FK_10AC9452CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE3441807E1D');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34C32A47EE');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6FE19A1A8');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6BEFD98D1');
        $this->addSql('ALTER TABLE inscription_student DROP FOREIGN KEY FK_9EF259DF5DAC5993');
        $this->addSql('ALTER TABLE inscription_student DROP FOREIGN KEY FK_9EF259DFCB944F1A');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F2465DAC5993');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246CB944F1A');
        $this->addSql('ALTER TABLE progress_training_block DROP FOREIGN KEY FK_F957EBA743DB87C9');
        $this->addSql('ALTER TABLE progress_training_block DROP FOREIGN KEY FK_F957EBA7E88919B');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92BEFD98D1');
        $this->addSql('ALTER TABLE quiz_question DROP FOREIGN KEY FK_6033B00B853CD175');
        $this->addSql('ALTER TABLE quiz_question_available_answer DROP FOREIGN KEY FK_D2E77847853CD175');
        $this->addSql('ALTER TABLE quiz_question_student_answer DROP FOREIGN KEY FK_EC222F6B3101E51F');
        $this->addSql('ALTER TABLE quiz_question_student_answer DROP FOREIGN KEY FK_EC222F6BCB944F1A');
        $this->addSql('ALTER TABLE quiz_student_event DROP FOREIGN KEY FK_9920A12BCB944F1A');
        $this->addSql('ALTER TABLE quiz_student_result DROP FOREIGN KEY FK_F7C680B3853CD175');
        $this->addSql('ALTER TABLE quiz_student_result DROP FOREIGN KEY FK_F7C680B3CB944F1A');
        $this->addSql('ALTER TABLE quiz_student_result DROP FOREIGN KEY FK_F7C680B35DAC5993');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416BEFD98D1');
        $this->addSql('ALTER TABLE school DROP FOREIGN KEY FK_F99EDABB41807E1D');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F41807E1D');
        $this->addSql('ALTER TABLE training_block DROP FOREIGN KEY FK_6CC11D4FBEFD98D1');
        $this->addSql('ALTER TABLE training_block DROP FOREIGN KEY FK_6CC11D4F853CD175');
        $this->addSql('ALTER TABLE training_block_resource DROP FOREIGN KEY FK_61980244E88919B');
        $this->addSql('ALTER TABLE training_block_resource DROP FOREIGN KEY FK_6198024489329D25');
        $this->addSql('ALTER TABLE training_category DROP FOREIGN KEY FK_E1290A5641807E1D');
        $this->addSql('ALTER TABLE training_objective DROP FOREIGN KEY FK_D71A92F5BEFD98D1');
        $this->addSql('ALTER TABLE training_session DROP FOREIGN KEY FK_D7A45DA5DAC5993');
        $this->addSql('ALTER TABLE training_session_training_block DROP FOREIGN KEY FK_CCB7AB8FDB8156B9');
        $this->addSql('ALTER TABLE training_session_training_block DROP FOREIGN KEY FK_CCB7AB8FE88919B');
        $this->addSql('ALTER TABLE training_session_student DROP FOREIGN KEY FK_10AC9452DB8156B9');
        $this->addSql('ALTER TABLE training_session_student DROP FOREIGN KEY FK_10AC9452CB944F1A');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_student');
        $this->addSql('DROP TABLE progress');
        $this->addSql('DROP TABLE progress_training_block');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_question');
        $this->addSql('DROP TABLE quiz_question_available_answer');
        $this->addSql('DROP TABLE quiz_question_student_answer');
        $this->addSql('DROP TABLE quiz_student_event');
        $this->addSql('DROP TABLE quiz_student_result');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_block');
        $this->addSql('DROP TABLE training_block_resource');
        $this->addSql('DROP TABLE training_category');
        $this->addSql('DROP TABLE training_objective');
        $this->addSql('DROP TABLE training_session');
        $this->addSql('DROP TABLE training_session_training_block');
        $this->addSql('DROP TABLE training_session_student');
    }
}
