<?php declare(strict_types = 1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180125045508 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE be_user (id INT AUTO_INCREMENT NOT NULL, postal_code INT DEFAULT NULL, locality INT DEFAULT NULL, township INT DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(64) NOT NULL, registry_date DATETIME NOT NULL, update_date DATETIME DEFAULT NULL, nb_error_connection INT NOT NULL, banned TINYINT(1) NOT NULL, registry_confirmed TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, token VARCHAR(255) NOT NULL, api_key VARCHAR(255) DEFAULT NULL, user_type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CFE84D14E7927C74 (email), UNIQUE INDEX UNIQ_CFE84D14C912ED9D (api_key), INDEX IDX_CFE84D14EA98E376 (postal_code), INDEX IDX_CFE84D14E1D6B8E6 (locality), INDEX IDX_CFE84D14DB97BC62 (township), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_position (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, bloc_id INT NOT NULL, place INT NOT NULL, INDEX IDX_DA14E41A19EB6921 (client_id), INDEX IDX_DA14E41A5582E9C0 (bloc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_abuse (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, comment_id INT DEFAULT NULL, description LONGTEXT NOT NULL, entry_date DATETIME NOT NULL, INDEX IDX_8D37D5E319EB6921 (client_id), INDEX IDX_8D37D5E3F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_image (id INT AUTO_INCREMENT NOT NULL, provider_logos_id INT DEFAULT NULL, provider_images_id INT DEFAULT NULL, place INT NOT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_D0A5528D39C3F456 (provider_logos_id), INDEX IDX_D0A5528DDD11D57 (provider_images_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_client (id INT NOT NULL, avatar_id INT DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, newsletter TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_AF8C2FFB86383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_favorite (client_id INT NOT NULL, provider_id INT NOT NULL, INDEX IDX_F4FD8E3619EB6921 (client_id), INDEX IDX_F4FD8E36A53A8AA (provider_id), PRIMARY KEY(client_id, provider_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_service (id INT AUTO_INCREMENT NOT NULL, provider_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, pricing VARCHAR(255) NOT NULL, additional_information LONGTEXT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, release_date DATETIME NOT NULL, expiry_date DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_D09BDC16A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_newsletter (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, release_date DATETIME NOT NULL, pdf VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (sess_id VARCHAR(128) NOT NULL, sess_data VARCHAR(255) NOT NULL, sess_time DATETIME NOT NULL, sess_lifetime INT NOT NULL, PRIMARY KEY(sess_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_provider (id INT NOT NULL, brand_name VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, email_contact VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(30) DEFAULT NULL, tva_number VARCHAR(20) DEFAULT NULL, street VARCHAR(255) NOT NULL, total_fan INT NOT NULL, rating INT NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EFC7373794474B9 (brand_name), UNIQUE INDEX UNIQ_EFC7373711F7047 (tva_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_provider_service_category (provider_id INT NOT NULL, service_category_id INT NOT NULL, INDEX IDX_51CE7327A53A8AA (provider_id), INDEX IDX_51CE7327DEDCBB4E (service_category_id), PRIMARY KEY(provider_id, service_category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_comment (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, provider_id INT NOT NULL, title VARCHAR(255) NOT NULL, positiveComment LONGTEXT DEFAULT NULL, negativeComment LONGTEXT DEFAULT NULL, vote INT NOT NULL, entry_date DATETIME NOT NULL, INDEX IDX_A57214A819EB6921 (client_id), INDEX IDX_A57214A8A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_service_category (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, in_front_page TINYINT(1) NOT NULL, is_valid TINYINT(1) DEFAULT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_59153AE05E237E06 (name), UNIQUE INDEX UNIQ_59153AE0989D9B62 (slug), UNIQUE INDEX UNIQ_59153AE03DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_promotion (id INT AUTO_INCREMENT NOT NULL, provider_id INT NOT NULL, service_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, pdf VARCHAR(255) DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, release_date DATETIME NOT NULL, expiry_date DATETIME NOT NULL, INDEX IDX_F134BA38A53A8AA (provider_id), INDEX IDX_F134BA38DEDCBB4E (service_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_temp_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, userType VARCHAR(12) NOT NULL, registry_date DATETIME NOT NULL, token VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_locality (id INT AUTO_INCREMENT NOT NULL, locality VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7DEEB809E1D6B8E6 (locality), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_postal_code (id INT AUTO_INCREMENT NOT NULL, code_postal INT NOT NULL, UNIQUE INDEX UNIQ_6024CCE9CC94AC37 (code_postal), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_bloc (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE be_township (id INT AUTO_INCREMENT NOT NULL, township VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_47AFBC8DDB97BC62 (township), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE be_user ADD CONSTRAINT FK_CFE84D14EA98E376 FOREIGN KEY (postal_code) REFERENCES be_postal_code (id)');
        $this->addSql('ALTER TABLE be_user ADD CONSTRAINT FK_CFE84D14E1D6B8E6 FOREIGN KEY (locality) REFERENCES be_locality (id)');
        $this->addSql('ALTER TABLE be_user ADD CONSTRAINT FK_CFE84D14DB97BC62 FOREIGN KEY (township) REFERENCES be_township (id)');
        $this->addSql('ALTER TABLE be_admin ADD CONSTRAINT FK_9D965BA4BF396750 FOREIGN KEY (id) REFERENCES be_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE be_position ADD CONSTRAINT FK_DA14E41A19EB6921 FOREIGN KEY (client_id) REFERENCES be_client (id)');
        $this->addSql('ALTER TABLE be_position ADD CONSTRAINT FK_DA14E41A5582E9C0 FOREIGN KEY (bloc_id) REFERENCES be_bloc (id)');
        $this->addSql('ALTER TABLE be_abuse ADD CONSTRAINT FK_8D37D5E319EB6921 FOREIGN KEY (client_id) REFERENCES be_client (id)');
        $this->addSql('ALTER TABLE be_abuse ADD CONSTRAINT FK_8D37D5E3F8697D13 FOREIGN KEY (comment_id) REFERENCES be_comment (id)');
        $this->addSql('ALTER TABLE be_image ADD CONSTRAINT FK_D0A5528D39C3F456 FOREIGN KEY (provider_logos_id) REFERENCES be_provider (id)');
        $this->addSql('ALTER TABLE be_image ADD CONSTRAINT FK_D0A5528DDD11D57 FOREIGN KEY (provider_images_id) REFERENCES be_provider (id)');
        $this->addSql('ALTER TABLE be_client ADD CONSTRAINT FK_AF8C2FFB86383B10 FOREIGN KEY (avatar_id) REFERENCES be_image (id)');
        $this->addSql('ALTER TABLE be_client ADD CONSTRAINT FK_AF8C2FFBBF396750 FOREIGN KEY (id) REFERENCES be_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE be_favorite ADD CONSTRAINT FK_F4FD8E3619EB6921 FOREIGN KEY (client_id) REFERENCES be_client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE be_favorite ADD CONSTRAINT FK_F4FD8E36A53A8AA FOREIGN KEY (provider_id) REFERENCES be_provider (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE be_service ADD CONSTRAINT FK_D09BDC16A53A8AA FOREIGN KEY (provider_id) REFERENCES be_provider (id)');
        $this->addSql('ALTER TABLE be_provider ADD CONSTRAINT FK_EFC7373BF396750 FOREIGN KEY (id) REFERENCES be_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE be_provider_service_category ADD CONSTRAINT FK_51CE7327A53A8AA FOREIGN KEY (provider_id) REFERENCES be_provider (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE be_provider_service_category ADD CONSTRAINT FK_51CE7327DEDCBB4E FOREIGN KEY (service_category_id) REFERENCES be_service_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE be_comment ADD CONSTRAINT FK_A57214A819EB6921 FOREIGN KEY (client_id) REFERENCES be_client (id)');
        $this->addSql('ALTER TABLE be_comment ADD CONSTRAINT FK_A57214A8A53A8AA FOREIGN KEY (provider_id) REFERENCES be_provider (id)');
        $this->addSql('ALTER TABLE be_service_category ADD CONSTRAINT FK_59153AE03DA5256D FOREIGN KEY (image_id) REFERENCES be_image (id)');
        $this->addSql('ALTER TABLE be_promotion ADD CONSTRAINT FK_F134BA38A53A8AA FOREIGN KEY (provider_id) REFERENCES be_provider (id)');
        $this->addSql('ALTER TABLE be_promotion ADD CONSTRAINT FK_F134BA38DEDCBB4E FOREIGN KEY (service_category_id) REFERENCES be_service_category (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE be_admin DROP FOREIGN KEY FK_9D965BA4BF396750');
        $this->addSql('ALTER TABLE be_client DROP FOREIGN KEY FK_AF8C2FFBBF396750');
        $this->addSql('ALTER TABLE be_provider DROP FOREIGN KEY FK_EFC7373BF396750');
        $this->addSql('ALTER TABLE be_client DROP FOREIGN KEY FK_AF8C2FFB86383B10');
        $this->addSql('ALTER TABLE be_service_category DROP FOREIGN KEY FK_59153AE03DA5256D');
        $this->addSql('ALTER TABLE be_position DROP FOREIGN KEY FK_DA14E41A19EB6921');
        $this->addSql('ALTER TABLE be_abuse DROP FOREIGN KEY FK_8D37D5E319EB6921');
        $this->addSql('ALTER TABLE be_favorite DROP FOREIGN KEY FK_F4FD8E3619EB6921');
        $this->addSql('ALTER TABLE be_comment DROP FOREIGN KEY FK_A57214A819EB6921');
        $this->addSql('ALTER TABLE be_image DROP FOREIGN KEY FK_D0A5528D39C3F456');
        $this->addSql('ALTER TABLE be_image DROP FOREIGN KEY FK_D0A5528DDD11D57');
        $this->addSql('ALTER TABLE be_favorite DROP FOREIGN KEY FK_F4FD8E36A53A8AA');
        $this->addSql('ALTER TABLE be_service DROP FOREIGN KEY FK_D09BDC16A53A8AA');
        $this->addSql('ALTER TABLE be_provider_service_category DROP FOREIGN KEY FK_51CE7327A53A8AA');
        $this->addSql('ALTER TABLE be_comment DROP FOREIGN KEY FK_A57214A8A53A8AA');
        $this->addSql('ALTER TABLE be_promotion DROP FOREIGN KEY FK_F134BA38A53A8AA');
        $this->addSql('ALTER TABLE be_abuse DROP FOREIGN KEY FK_8D37D5E3F8697D13');
        $this->addSql('ALTER TABLE be_provider_service_category DROP FOREIGN KEY FK_51CE7327DEDCBB4E');
        $this->addSql('ALTER TABLE be_promotion DROP FOREIGN KEY FK_F134BA38DEDCBB4E');
        $this->addSql('ALTER TABLE be_user DROP FOREIGN KEY FK_CFE84D14E1D6B8E6');
        $this->addSql('ALTER TABLE be_user DROP FOREIGN KEY FK_CFE84D14EA98E376');
        $this->addSql('ALTER TABLE be_position DROP FOREIGN KEY FK_DA14E41A5582E9C0');
        $this->addSql('ALTER TABLE be_user DROP FOREIGN KEY FK_CFE84D14DB97BC62');
        $this->addSql('DROP TABLE be_user');
        $this->addSql('DROP TABLE be_admin');
        $this->addSql('DROP TABLE be_position');
        $this->addSql('DROP TABLE be_abuse');
        $this->addSql('DROP TABLE be_image');
        $this->addSql('DROP TABLE be_client');
        $this->addSql('DROP TABLE be_favorite');
        $this->addSql('DROP TABLE be_service');
        $this->addSql('DROP TABLE be_newsletter');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE be_provider');
        $this->addSql('DROP TABLE be_provider_service_category');
        $this->addSql('DROP TABLE be_comment');
        $this->addSql('DROP TABLE be_service_category');
        $this->addSql('DROP TABLE be_promotion');
        $this->addSql('DROP TABLE be_temp_user');
        $this->addSql('DROP TABLE be_locality');
        $this->addSql('DROP TABLE be_postal_code');
        $this->addSql('DROP TABLE be_bloc');
        $this->addSql('DROP TABLE be_township');
    }
}
