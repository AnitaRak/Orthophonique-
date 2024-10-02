<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117055806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, test_id INT NOT NULL, status VARCHAR(90) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', score INT DEFAULT NULL,user_id INT NOT NULL, INDEX IDX_1323A5756B899279 (patient_id), INDEX IDX_1323A5751E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE illustration (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, path VARCHAR(500) NOT NULL, type VARCHAR(80) NOT NULL, INDEX IDX_D67B9A42126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, school_grade_id INT DEFAULT NULL, name_cr VARCHAR(90) DEFAULT NULL, name_fr VARCHAR(90) NOT NULL, active TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_1F1B251E1E5D0459 (test_id), INDEX IDX_1F1B251E5F95EC (school_grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_response (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, template_value_id INT NOT NULL, name VARCHAR(90) NOT NULL, INDEX IDX_1E0C7A5F1E27F6BF (question_id), INDEX IDX_1E0C7A5FA6768BD1 (template_value_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_response_media (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_response_media_option_response (option_response_media_id INT NOT NULL, option_response_id INT NOT NULL, INDEX IDX_3CAE18E9AA589275 (option_response_media_id), INDEX IDX_3CAE18E9DDC771F4 (option_response_id), PRIMARY KEY(option_response_media_id, option_response_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, school_grade_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date DATE DEFAULT NULL, gender VARCHAR(5) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1ADAD7EB5F95EC (school_grade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient_user (patient_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4029B816B899279 (patient_id), INDEX IDX_4029B81A76ED395 (user_id), PRIMARY KEY(patient_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, template_question_id INT NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_B6F7494E126F525E (item_id), INDEX IDX_B6F7494E15DEE2DB (template_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, patient_id INT NOT NULL, item_id INT NOT NULL, text VARCHAR(800) DEFAULT NULL, audio VARCHAR(300) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3E7B0BFB456C5646 (evaluation_id), INDEX IDX_3E7B0BFB6B899279 (patient_id), INDEX IDX_3E7B0BFB126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_grade (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, response_id INT NOT NULL, points INT NOT NULL, value_name VARCHAR(255) DEFAULT NULL, response_name VARCHAR(255) DEFAULT NULL, is_included_in_total_score TINYINT(1) NOT NULL, INDEX IDX_329937511E27F6BF (question_id), INDEX IDX_32993751FBF32840 (response_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template_question (id INT AUTO_INCREMENT NOT NULL, test_id INT NOT NULL, requires_audio TINYINT(1) NOT NULL, requires_text TINYINT(1) NOT NULL, is_included_in_total_score TINYINT(1) NOT NULL, is_mcq TINYINT(1) NOT NULL, is_custom_score TINYINT(1) NOT NULL, instructions_fr VARCHAR(255) DEFAULT NULL, instructions_cr VARCHAR(255) DEFAULT NULL, INDEX IDX_E9A1793D1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE template_value (id INT AUTO_INCREMENT NOT NULL, template_question_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, complete_name VARCHAR(255) DEFAULT NULL, score INT NOT NULL, INDEX IDX_2EA18BFB15DEE2DB (template_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, type_test_id INT NOT NULL, name VARCHAR(50) NOT NULL, is_timed TINYINT(1) NOT NULL, timer INT DEFAULT NULL, instructions_fr VARCHAR(255) NOT NULL, instructions_cr VARCHAR(800) DEFAULT NULL, implementation_advice VARCHAR(800) DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_D87F7E0C367C6BAC (type_test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, phone VARCHAR(50) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, reset_token VARCHAR(100) DEFAULT NULL, create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', no_adeli INT NOT NULL, status VARCHAR(100) NOT NULL, address VARCHAR(50) DEFAULT NULL, zipcode INT DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, active SMALLINT NOT NULL, inscription_status VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649834921FB (no_adeli), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5756B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5751E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE illustration ADD CONSTRAINT FK_D67B9A42126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E5F95EC FOREIGN KEY (school_grade_id) REFERENCES school_grade (id)');
        $this->addSql('ALTER TABLE option_response ADD CONSTRAINT FK_1E0C7A5F1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE option_response ADD CONSTRAINT FK_1E0C7A5FA6768BD1 FOREIGN KEY (template_value_id) REFERENCES template_value (id)');
        $this->addSql('ALTER TABLE option_response_media_option_response ADD CONSTRAINT FK_3CAE18E9AA589275 FOREIGN KEY (option_response_media_id) REFERENCES option_response_media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_response_media_option_response ADD CONSTRAINT FK_3CAE18E9DDC771F4 FOREIGN KEY (option_response_id) REFERENCES option_response (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB5F95EC FOREIGN KEY (school_grade_id) REFERENCES school_grade (id)');
        $this->addSql('ALTER TABLE patient_user ADD CONSTRAINT FK_4029B816B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_user ADD CONSTRAINT FK_4029B81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E15DEE2DB FOREIGN KEY (template_question_id) REFERENCES template_question (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_329937511E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751FBF32840 FOREIGN KEY (response_id) REFERENCES response (id)');
        $this->addSql('ALTER TABLE template_question ADD CONSTRAINT FK_E9A1793D1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE template_value ADD CONSTRAINT FK_2EA18BFB15DEE2DB FOREIGN KEY (template_question_id) REFERENCES template_question (id)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C367C6BAC FOREIGN KEY (type_test_id) REFERENCES test_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5756B899279');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5751E5D0459');
        $this->addSql('ALTER TABLE illustration DROP FOREIGN KEY FK_D67B9A42126F525E');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E1E5D0459');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E5F95EC');
        $this->addSql('ALTER TABLE option_response DROP FOREIGN KEY FK_1E0C7A5F1E27F6BF');
        $this->addSql('ALTER TABLE option_response DROP FOREIGN KEY FK_1E0C7A5FA6768BD1');
        $this->addSql('ALTER TABLE option_response_media_option_response DROP FOREIGN KEY FK_3CAE18E9AA589275');
        $this->addSql('ALTER TABLE option_response_media_option_response DROP FOREIGN KEY FK_3CAE18E9DDC771F4');
        $this->addSql('ALTER TABLE patient DROP FOREIGN KEY FK_1ADAD7EB5F95EC');
        $this->addSql('ALTER TABLE patient_user DROP FOREIGN KEY FK_4029B816B899279');
        $this->addSql('ALTER TABLE patient_user DROP FOREIGN KEY FK_4029B81A76ED395');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E126F525E');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E15DEE2DB');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB456C5646');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB6B899279');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB126F525E');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_329937511E27F6BF');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751FBF32840');
        $this->addSql('ALTER TABLE template_question DROP FOREIGN KEY FK_E9A1793D1E5D0459');
        $this->addSql('ALTER TABLE template_value DROP FOREIGN KEY FK_2EA18BFB15DEE2DB');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C367C6BAC');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE illustration');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE option_response');
        $this->addSql('DROP TABLE option_response_media');
        $this->addSql('DROP TABLE option_response_media_option_response');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE patient_user');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE school_grade');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE template_question');
        $this->addSql('DROP TABLE template_value');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE test_type');
        $this->addSql('DROP TABLE user');
    }
}
