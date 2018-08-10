<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180810110148 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, ref_image_id INT DEFAULT NULL, date DATETIME NOT NULL, title LONGTEXT DEFAULT NULL, texte LONGTEXT DEFAULT NULL, ordre INT NOT NULL, link LONGTEXT DEFAULT NULL, position_image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C0155143BBB2E3EA (ref_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_images (id INT AUTO_INCREMENT NOT NULL, image_src LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config (id INT AUTO_INCREMENT NOT NULL, p_annee INT NOT NULL, nb_sess_req INT DEFAULT NULL, path_photo VARCHAR(255) NOT NULL, path_certif VARCHAR(255) NOT NULL, path_fiches VARCHAR(255) NOT NULL, path_fact VARCHAR(255) NOT NULL, path_team VARCHAR(255) NOT NULL, log_ap VARCHAR(255) NOT NULL, log_db VARCHAR(255) NOT NULL, log_ml VARCHAR(255) NOT NULL, status_inscriptions INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143BBB2E3EA FOREIGN KEY (ref_image_id) REFERENCES blog_images (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143BBB2E3EA');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_images');
        $this->addSql('DROP TABLE config');
    }
}
