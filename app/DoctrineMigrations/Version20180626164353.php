<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626164353  extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $eventStore = $this->container->get('prooph_event_store.holiday_store');
        $streamName = new StreamName('event_stream');
        $singleStream = new Stream($streamName, new \ArrayIterator());
        if (!$eventStore->hasStream($streamName)) {
            $eventStore->create($singleStream);
        }
    }
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $eventStore = $this->container->get('prooph_event_store.holiday_store');
        $streamName = new StreamName('event_stream');
        $eventStore->delete($streamName);
    }

    public function isTransactional()
    {
        return false;
    }
}
