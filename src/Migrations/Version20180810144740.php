<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180810144740 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adherents (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(128) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, add1 VARCHAR(255) NOT NULL, add2 VARCHAR(255) NOT NULL, code_postal VARCHAR(32) NOT NULL, ville VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, date_naiss DATETIME NOT NULL, lieu_naiss VARCHAR(255) NOT NULL, depart_naiss VARCHAR(255) NOT NULL, tel_fix VARCHAR(255) NOT NULL, tel_port VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, f_etudiant TINYINT(1) NOT NULL, niveau_sca VARCHAR(32) NOT NULL, niveau_apn VARCHAR(32) NOT NULL, apnee_sca TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplomes (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, date_obtention DATETIME NOT NULL, date_recyclage DATETIME NOT NULL, numero VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, INDEX IDX_8A81EFD1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diplomes ADD CONSTRAINT FK_8A81EFD1A76ED395 FOREIGN KEY (user_id) REFERENCES adherents (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diplomes DROP FOREIGN KEY FK_8A81EFD1A76ED395');
        $this->addSql('DROP TABLE adherents');
        $this->addSql('DROP TABLE diplomes');
    }
}
