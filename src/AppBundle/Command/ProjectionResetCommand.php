<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProjectionResetCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('projection:reset')
            ->setDescription('Reset projection')
            ->addArgument('projection-name', InputArgument::REQUIRED, 'Name of projection')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('projection-name');
        $this->getContainer()->get('projection_manager')->resetProjection($name);
        $output->writeln('Projection resetted...');
    }
}