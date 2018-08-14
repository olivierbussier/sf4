<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180814113538 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adherent (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, roles JSON DEFAULT NULL, liste_droits JSON DEFAULT NULL, code_secret VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, genre VARCHAR(32) NOT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(32) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, profession VARCHAR(255) DEFAULT NULL, date_naissance DATETIME NOT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, departement_naissance VARCHAR(255) DEFAULT NULL, tel_fix VARCHAR(64) DEFAULT NULL, tel_port VARCHAR(64) DEFAULT NULL, f_etudiant TINYINT(1) DEFAULT NULL, niveau_sca VARCHAR(64) NOT NULL, niveau_apn VARCHAR(64) NOT NULL, diplomes JSON DEFAULT NULL, f_apnee_sca TINYINT(1) DEFAULT NULL, activite VARCHAR(64) DEFAULT NULL, f_benevole TINYINT(1) DEFAULT NULL, f_encadrant TINYINT(1) DEFAULT NULL, accident_nom VARCHAR(255) DEFAULT NULL, accident_prenom VARCHAR(255) DEFAULT NULL, accident_tel_fix VARCHAR(64) DEFAULT NULL, accident_tel_port VARCHAR(64) DEFAULT NULL, date_certif DATETIME DEFAULT NULL, f_allerg_aspirine TINYINT(1) DEFAULT NULL, licence VARCHAR(32) DEFAULT NULL, cotisation VARCHAR(32) DEFAULT NULL, f_carte_guc TINYINT(1) DEFAULT NULL, f_carte_siuaps TINYINT(1) DEFAULT NULL, f_mail_guc TINYINT(1) DEFAULT NULL, f_trombi TINYINT(1) DEFAULT NULL, envoi_guc VARCHAR(32) DEFAULT NULL, envoi_siuaps VARCHAR(32) DEFAULT NULL, facture VARCHAR(255) DEFAULT NULL, ref_facture VARCHAR(255) DEFAULT NULL, assurance VARCHAR(32) DEFAULT NULL, pret_materiel TINYINT(1) DEFAULT NULL, pret_materiel_old TINYINT(1) DEFAULT NULL, mineur_nom VARCHAR(255) DEFAULT NULL, mineur_prenom VARCHAR(255) DEFAULT NULL, mineur_qualite VARCHAR(255) DEFAULT NULL, modif_user VARCHAR(255) DEFAULT NULL, date_modif_user DATETIME DEFAULT NULL, date_prem_inscr DATETIME DEFAULT NULL, admin_ok JSON DEFAULT NULL, comments LONGTEXT DEFAULT NULL, reduc_famille_id VARCHAR(32) DEFAULT NULL, reduc_fam VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, ref_image_id INT DEFAULT NULL, date DATETIME NOT NULL, title LONGTEXT DEFAULT NULL, texte LONGTEXT DEFAULT NULL, ordre INT NOT NULL, link LONGTEXT DEFAULT NULL, position_image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C0155143BBB2E3EA (ref_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_images (id INT AUTO_INCREMENT NOT NULL, image_src LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplomes (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, date_obtention DATETIME NOT NULL, date_recyclage DATETIME NOT NULL, numero VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, INDEX IDX_8A81EFD1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143BBB2E3EA FOREIGN KEY (ref_image_id) REFERENCES blog_images (id)');
        $this->addSql('ALTER TABLE diplomes ADD CONSTRAINT FK_8A81EFD1A76ED395 FOREIGN KEY (user_id) REFERENCES adherent (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diplomes DROP FOREIGN KEY FK_8A81EFD1A76ED395');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143BBB2E3EA');
        $this->addSql('DROP TABLE adherent');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_images');
        $this->addSql('DROP TABLE diplomes');
    }
}
