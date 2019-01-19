<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190119080900 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE gvgparty_user');
        $this->addSql('ALTER TABLE user ADD excluded TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gvgparty_user (gvgparty_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_BFD642C79523E4D5 (gvgparty_id), INDEX IDX_BFD642C7A76ED395 (user_id), PRIMARY KEY(gvgparty_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gvgparty_user ADD CONSTRAINT FK_BFD642C79523E4D5 FOREIGN KEY (gvgparty_id) REFERENCES gvgparty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gvgparty_user ADD CONSTRAINT FK_BFD642C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP excluded');
    }
}
