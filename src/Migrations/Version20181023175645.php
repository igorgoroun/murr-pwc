<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181023175645 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, access_id INT NOT NULL, name VARCHAR(128) NOT NULL, INDEX IDX_852BBECD4FEA67CF (access_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_directory (id INT AUTO_INCREMENT NOT NULL, forum_id INT NOT NULL, access_id INT NOT NULL, name VARCHAR(128) NOT NULL, INDEX IDX_7831C08C29CCBAD0 (forum_id), INDEX IDX_7831C08C4FEA67CF (access_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, topic_id INT NOT NULL, body LONGTEXT DEFAULT NULL, sign TINYINT(1) NOT NULL, pick_top TINYINT(1) NOT NULL, INDEX IDX_996BCC5AA76ED395 (user_id), INDEX IDX_996BCC5A1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum_topic (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, directory_id INT NOT NULL, heading VARCHAR(128) NOT NULL, description VARCHAR(255) DEFAULT NULL, post_body LONGTEXT DEFAULT NULL, sign TINYINT(1) NOT NULL, picked_top TINYINT(1) NOT NULL, INDEX IDX_853478CCA76ED395 (user_id), INDEX IDX_853478CC2C94069F (directory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD4FEA67CF FOREIGN KEY (access_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE forum_directory ADD CONSTRAINT FK_7831C08C29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE forum_directory ADD CONSTRAINT FK_7831C08C4FEA67CF FOREIGN KEY (access_id) REFERENCES user_group (id)');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5A1F55203D FOREIGN KEY (topic_id) REFERENCES forum_topic (id)');
        $this->addSql('ALTER TABLE forum_topic ADD CONSTRAINT FK_853478CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE forum_topic ADD CONSTRAINT FK_853478CC2C94069F FOREIGN KEY (directory_id) REFERENCES forum_directory (id)');
        $this->addSql('ALTER TABLE page ADD created DATETIME NOT NULL, ADD modified DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE forum_directory DROP FOREIGN KEY FK_7831C08C29CCBAD0');
        $this->addSql('ALTER TABLE forum_topic DROP FOREIGN KEY FK_853478CC2C94069F');
        $this->addSql('ALTER TABLE forum_post DROP FOREIGN KEY FK_996BCC5A1F55203D');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE forum_directory');
        $this->addSql('DROP TABLE forum_post');
        $this->addSql('DROP TABLE forum_topic');
        $this->addSql('ALTER TABLE page DROP created, DROP modified');
    }
}
