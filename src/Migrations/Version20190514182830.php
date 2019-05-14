<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190514182830 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(70) NOT NULL, last_name VARCHAR(70) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(70) NOT NULL, last_name VARCHAR(70) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(70) NOT NULL, last_name VARCHAR(70) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, started_at DATETIME NOT NULL, finished_at DATETIME DEFAULT NULL, duration VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, have_teacher TINYINT(1) NOT NULL, INDEX IDX_D5128A8F41807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE training_student (training_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_6A1D3F3DBEFD98D1 (training_id), INDEX IDX_6A1D3F3DCB944F1A (student_id), PRIMARY KEY(training_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE training ADD CONSTRAINT FK_D5128A8F41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE training_student ADD CONSTRAINT FK_6A1D3F3DBEFD98D1 FOREIGN KEY (training_id) REFERENCES training (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE training_student ADD CONSTRAINT FK_6A1D3F3DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE training_student DROP FOREIGN KEY FK_6A1D3F3DCB944F1A');
        $this->addSql('ALTER TABLE training DROP FOREIGN KEY FK_D5128A8F41807E1D');
        $this->addSql('ALTER TABLE training_student DROP FOREIGN KEY FK_6A1D3F3DBEFD98D1');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE training');
        $this->addSql('DROP TABLE training_student');
    }
}
