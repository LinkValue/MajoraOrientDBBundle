<?php

namespace Majora\Bundle\OrientDbGraphBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * OrientDB database deletion command
 */
class DropDatabaseCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('majora:orientdb_graph:drop_database')
            ->setDescription('.')
            ->addArgument('connection', InputArgument::REQUIRED, 'Connection name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('majora.orient_db.graph_engine')
            ->dropDatabase($input->getArgument('connection'))
        ;
    }
}
