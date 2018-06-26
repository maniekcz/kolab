<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626164210 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql(file_get_contents(__DIR__ . '/../../vendor/prooph/pdo-event-store/scripts/mysql/01_event_streams_table.sql'));
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE event_streams');
    }
}
