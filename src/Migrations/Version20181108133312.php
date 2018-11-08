<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181108133312 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gvg (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, time TIME DEFAULT NULL, enemy VARCHAR(64) DEFAULT NULL, territory VARCHAR(64) DEFAULT NULL, hint LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gvgpresence (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, gvg_id INT NOT NULL, promise TINYINT(1) NOT NULL, INDEX IDX_DD683329A76ED395 (user_id), INDEX IDX_DD683329ED5058B6 (gvg_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gvgparty (id INT AUTO_INCREMENT NOT NULL, gvg_id INT NOT NULL, name VARCHAR(64) DEFAULT NULL, promise TINYINT(1) NOT NULL, was TINYINT(1) DEFAULT NULL, INDEX IDX_6AF215C5ED5058B6 (gvg_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gvgparty_user (gvgparty_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_BFD642C79523E4D5 (gvgparty_id), INDEX IDX_BFD642C7A76ED395 (user_id), PRIMARY KEY(gvgparty_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gvgpresence ADD CONSTRAINT FK_DD683329A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE gvgpresence ADD CONSTRAINT FK_DD683329ED5058B6 FOREIGN KEY (gvg_id) REFERENCES gvg (id)');
        $this->addSql('ALTER TABLE gvgparty ADD CONSTRAINT FK_6AF215C5ED5058B6 FOREIGN KEY (gvg_id) REFERENCES gvg (id)');
        $this->addSql('ALTER TABLE gvgparty_user ADD CONSTRAINT FK_BFD642C79523E4D5 FOREIGN KEY (gvgparty_id) REFERENCES gvgparty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gvgparty_user ADD CONSTRAINT FK_BFD642C7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gvgpresence DROP FOREIGN KEY FK_DD683329ED5058B6');
        $this->addSql('ALTER TABLE gvgparty DROP FOREIGN KEY FK_6AF215C5ED5058B6');
        $this->addSql('ALTER TABLE gvgparty_user DROP FOREIGN KEY FK_BFD642C79523E4D5');
        $this->addSql('DROP TABLE gvg');
        $this->addSql('DROP TABLE gvgpresence');
        $this->addSql('DROP TABLE gvgparty');
        $this->addSql('DROP TABLE gvgparty_user');
    }
}
