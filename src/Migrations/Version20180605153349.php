<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180605153349 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE algorithm_param DROP FOREIGN KEY FK_F3E45D5BBBEB6CF7');
        $this->addSql('ALTER TABLE algorithm_param ADD CONSTRAINT FK_F3E45D5BBBEB6CF7 FOREIGN KEY (algorithm_id) REFERENCES algorithm (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE algorithm_param DROP FOREIGN KEY FK_F3E45D5BBBEB6CF7');
        $this->addSql('ALTER TABLE algorithm_param ADD CONSTRAINT FK_F3E45D5BBBEB6CF7 FOREIGN KEY (algorithm_id) REFERENCES algorithm (id)');
    }
}
