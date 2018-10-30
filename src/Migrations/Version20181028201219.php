<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181028201219 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE forum_post ADD directory_id INT NOT NULL');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5A2C94069F FOREIGN KEY (directory_id) REFERENCES forum_directory (id)');
        $this->addSql('CREATE INDEX IDX_996BCC5A2C94069F ON forum_post (directory_id)');
        $this->addSql('ALTER TABLE forum_topic ADD access_id INT DEFAULT NULL, DROP post_body, DROP sign');
        $this->addSql('ALTER TABLE forum_topic ADD CONSTRAINT FK_853478CC4FEA67CF FOREIGN KEY (access_id) REFERENCES user_group (id)');
        $this->addSql('CREATE INDEX IDX_853478CC4FEA67CF ON forum_topic (access_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE forum_post DROP FOREIGN KEY FK_996BCC5A2C94069F');
        $this->addSql('DROP INDEX IDX_996BCC5A2C94069F ON forum_post');
        $this->addSql('ALTER TABLE forum_post DROP directory_id');
        $this->addSql('ALTER TABLE forum_topic DROP FOREIGN KEY FK_853478CC4FEA67CF');
        $this->addSql('DROP INDEX IDX_853478CC4FEA67CF ON forum_topic');
        $this->addSql('ALTER TABLE forum_topic ADD post_body LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD sign TINYINT(1) NOT NULL, DROP access_id');
    }
}
