<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181016200918 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE char_class (id INT AUTO_INCREMENT NOT NULL, party_role_id INT DEFAULT NULL, name VARCHAR(32) NOT NULL, INDEX IDX_8FE6C13EC4F2BD87 (party_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE party_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE char_class ADD CONSTRAINT FK_8FE6C13EC4F2BD87 FOREIGN KEY (party_role_id) REFERENCES party_role (id)');
        $this->addSql('ALTER TABLE user ADD char_class_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D33CAC67 FOREIGN KEY (char_class_id) REFERENCES char_class (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D33CAC67 ON user (char_class_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D33CAC67');
        $this->addSql('ALTER TABLE char_class DROP FOREIGN KEY FK_8FE6C13EC4F2BD87');
        $this->addSql('DROP TABLE char_class');
        $this->addSql('DROP TABLE party_role');
        $this->addSql('DROP INDEX IDX_8D93D649D33CAC67 ON user');
        $this->addSql('ALTER TABLE user DROP char_class_id');
    }
}
