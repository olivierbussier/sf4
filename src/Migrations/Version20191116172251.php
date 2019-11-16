<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191116172251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adherent (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, code_secret VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, genre VARCHAR(32) NOT NULL, inscr_type INT DEFAULT NULL, adresse1 VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(32) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, profession VARCHAR(255) DEFAULT NULL, date_naissance DATETIME NOT NULL, lieu_naissance VARCHAR(255) DEFAULT NULL, departement_naissance VARCHAR(255) DEFAULT NULL, tel_fix VARCHAR(64) DEFAULT NULL, tel_port VARCHAR(64) DEFAULT NULL, f_etudiant TINYINT(1) DEFAULT NULL, niveau_sca VARCHAR(64) NOT NULL, niveau_apn VARCHAR(64) NOT NULL, f_apnee_sca TINYINT(1) DEFAULT NULL, activite VARCHAR(64) DEFAULT NULL, f_benevole TINYINT(1) DEFAULT NULL, f_encadrant TINYINT(1) DEFAULT NULL, accident_nom VARCHAR(255) DEFAULT NULL, accident_prenom VARCHAR(255) DEFAULT NULL, accident_tel_fix VARCHAR(64) DEFAULT NULL, accident_tel_port VARCHAR(64) DEFAULT NULL, date_certif DATETIME DEFAULT NULL, f_allerg_aspirine TINYINT(1) DEFAULT NULL, licence VARCHAR(32) DEFAULT NULL, cotisation VARCHAR(32) DEFAULT NULL, f_carte_guc TINYINT(1) DEFAULT NULL, f_carte_siuaps TINYINT(1) DEFAULT NULL, f_mail_guc TINYINT(1) DEFAULT NULL, f_trombi TINYINT(1) DEFAULT NULL, envoi_guc VARCHAR(32) DEFAULT NULL, envoi_siuaps VARCHAR(32) DEFAULT NULL, facture VARCHAR(255) DEFAULT NULL, ref_facture VARCHAR(255) DEFAULT NULL, assurance VARCHAR(32) DEFAULT NULL, pret_materiel TINYINT(1) DEFAULT NULL, pret_materiel_old TINYINT(1) DEFAULT NULL, mineur_nom VARCHAR(255) DEFAULT NULL, mineur_prenom VARCHAR(255) DEFAULT NULL, mineur_qualite VARCHAR(255) DEFAULT NULL, modif_user VARCHAR(255) DEFAULT NULL, date_modif_user DATETIME DEFAULT NULL, date_prem_inscr DATETIME DEFAULT NULL, admin_ok TEXT DEFAULT NULL, comments LONGTEXT DEFAULT NULL, reduc_famille_id VARCHAR(32) DEFAULT NULL, reduc_fam VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, posted_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, position INT NOT NULL, link VARCHAR(255) DEFAULT NULL, position_image VARCHAR(16) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calendrier (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, lieu VARCHAR(255) NOT NULL, seance_materiel VARCHAR(8) NOT NULL, resp_materiel VARCHAR(255) DEFAULT NULL, seance_bassin VARCHAR(8) NOT NULL, resp_bassin VARCHAR(255) DEFAULT NULL, seance_gonflage VARCHAR(8) NOT NULL, resp_gonflage VARCHAR(255) DEFAULT NULL, aide_gonf1 VARCHAR(255) DEFAULT NULL, aide1validee VARCHAR(8) NOT NULL, aide_gonf2 VARCHAR(255) DEFAULT NULL, aide2validee VARCHAR(8) NOT NULL, aide_gonf3 VARCHAR(255) DEFAULT NULL, aide3validee VARCHAR(8) NOT NULL, archive VARCHAR(8) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplome (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, date_obtention DATETIME DEFAULT NULL, date_recyclage DATETIME DEFAULT NULL, numero VARCHAR(255) NOT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_EB4C4D4EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loc_refs (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mat_cal (id INT AUTO_INCREMENT NOT NULL, mat_carac_id INT NOT NULL, ref_user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, type_sortie VARCHAR(255) NOT NULL, status VARCHAR(64) NOT NULL, asset_text VARCHAR(255) NOT NULL, commentaire LONGTEXT DEFAULT NULL, ref_resa INT DEFAULT NULL, INDEX IDX_59EA75B32FB51FC5 (mat_carac_id), INDEX IDX_59EA75B3637A8045 (ref_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mat_carac (id INT AUTO_INCREMENT NOT NULL, usage_count INT NOT NULL, asset_num VARCHAR(64) NOT NULL, asset_type VARCHAR(32) NOT NULL, caracteristique VARCHAR(32) NOT NULL, status VARCHAR(128) NOT NULL, commentaire LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, adherent_id INT DEFAULT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_57698A6A25F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4EA76ED395 FOREIGN KEY (user_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE mat_cal ADD CONSTRAINT FK_59EA75B32FB51FC5 FOREIGN KEY (mat_carac_id) REFERENCES mat_carac (id)');
        $this->addSql('ALTER TABLE mat_cal ADD CONSTRAINT FK_59EA75B3637A8045 FOREIGN KEY (ref_user_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE role ADD CONSTRAINT FK_57698A6A25F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diplome DROP FOREIGN KEY FK_EB4C4D4EA76ED395');
        $this->addSql('ALTER TABLE mat_cal DROP FOREIGN KEY FK_59EA75B3637A8045');
        $this->addSql('ALTER TABLE role DROP FOREIGN KEY FK_57698A6A25F06C53');
        $this->addSql('ALTER TABLE mat_cal DROP FOREIGN KEY FK_59EA75B32FB51FC5');
        $this->addSql('DROP TABLE adherent');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE calendrier');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE loc_refs');
        $this->addSql('DROP TABLE mat_cal');
        $this->addSql('DROP TABLE mat_carac');
        $this->addSql('DROP TABLE role');
    }
}
