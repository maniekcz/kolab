<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Kolab\Holiday\Infrastructure\Projection\Table;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626165141 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable(Table::READ_HOLIDAY);
        $table->addColumn('id', 'string', ['length' => 36]);
        $table->addColumn('customer_id', 'string', ['length' => 36]);
        $table->addColumn('start', 'datetime');
        $table->addColumn('state', 'string');
        $table->addColumn('created', 'datetime');
        $table->addColumn('updated', 'datetime');
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable(Table::READ_HOLIDAY);

    }
}
