<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181023155000 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, char_class_id INT NOT NULL, user_id INT NOT NULL, char_side_id INT NOT NULL, age INT NOT NULL, region VARCHAR(64) DEFAULT NULL, twins VARCHAR(128) DEFAULT NULL, gvg_experience TINYINT(1) NOT NULL, previous_exits LONGTEXT NOT NULL, our_reasons LONGTEXT NOT NULL, guarantors VARCHAR(255) DEFAULT NULL, confirm_statement TINYINT(1) NOT NULL, INDEX IDX_B66FFE92D33CAC67 (char_class_id), INDEX IDX_B66FFE92A76ED395 (user_id), INDEX IDX_B66FFE92A9493427 (char_side_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE char_side (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92D33CAC67 FOREIGN KEY (char_class_id) REFERENCES char_class (id)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92A9493427 FOREIGN KEY (char_side_id) REFERENCES char_side (id)');
        $this->addSql('ALTER TABLE user ADD char_side_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A9493427 FOREIGN KEY (char_side_id) REFERENCES char_side (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A9493427 ON user (char_side_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A9493427');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE92A9493427');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE char_side');
        $this->addSql('DROP INDEX IDX_8D93D649A9493427 ON user');
        $this->addSql('ALTER TABLE user DROP char_side_id');
    }
}
