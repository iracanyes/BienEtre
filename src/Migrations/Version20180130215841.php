<?php declare(strict_types = 1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180130215841 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE be_user CHANGE roles roles TINYTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE be_session CHANGE sess_id sess_id VARCHAR(128) NOT NULL, CHANGE sess_data sess_data LONGBLOB NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE be_session CHANGE sess_id sess_id VARCHAR(128) NOT NULL COLLATE utf8_unicode_ci, CHANGE sess_data sess_data VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE be_user CHANGE roles roles VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
