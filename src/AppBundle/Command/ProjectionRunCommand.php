<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Kolab\Model\Projections;

class ProjectionRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('projection:run')
            ->setDescription('Run projection')
            ->addArgument('projection-service-name', InputArgument::REQUIRED, 'Name of projection service')
            ->addArgument('keep-running', InputArgument::REQUIRED, 'Keep running')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectionServiceName = $input->getArgument('projection-service-name');
        $keepRunning = ($input->getArgument('keep-running') == 'yes');
        $service = $this->getContainer()->get($projectionServiceName);
        $output->writeln('Starting projection ' . $projectionServiceName);
        if ($service instanceof Projections) {
            $service($keepRunning);
            $output->writeln('Finished...');
        } else {
            $output->writeln('Wrong projection');
        }
    }
}