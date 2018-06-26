<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626164253 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql(file_get_contents(__DIR__ . '/../../vendor/prooph/pdo-event-store/scripts/mysql/02_projections_table.sql'));
    }
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE projections');
    }
}
