<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180604104413 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE algorithm (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE algorithm_param (id INT AUTO_INCREMENT NOT NULL, algorithm_id INT NOT NULL, name VARCHAR(20) NOT NULL, title VARCHAR(255) NOT NULL, INDEX algorithm_id (algorithm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE algorithm_param ADD CONSTRAINT FK_F3E45D5BBBEB6CF7 FOREIGN KEY (algorithm_id) REFERENCES algorithm (id)');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY fk_profile_user');
        $this->addSql('ALTER TABLE profile CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_957a647992fc23a8 TO UNIQ_8D93D64992FC23A8');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_957a6479a0d96fbf TO UNIQ_8D93D649A0D96FBF');
        $this->addSql('ALTER TABLE user RENAME INDEX uniq_957a6479c05fb297 TO UNIQ_8D93D649C05FB297');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE algorithm_param DROP FOREIGN KEY FK_F3E45D5BBBEB6CF7');
        $this->addSql('DROP TABLE algorithm');
        $this->addSql('DROP TABLE algorithm_param');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE profile CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT fk_profile_user FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` RENAME INDEX uniq_8d93d64992fc23a8 TO UNIQ_957A647992FC23A8');
        $this->addSql('ALTER TABLE `user` RENAME INDEX uniq_8d93d649a0d96fbf TO UNIQ_957A6479A0D96FBF');
        $this->addSql('ALTER TABLE `user` RENAME INDEX uniq_8d93d649c05fb297 TO UNIQ_957A6479C05FB297');
    }
}
