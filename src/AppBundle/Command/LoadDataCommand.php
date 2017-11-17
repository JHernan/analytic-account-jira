<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 10/11/17
 * Time: 20:44
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadDataCommand extends ContainerAwareCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('app:load-data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<comment>Load all data</comment>');

        $command = $this->getApplication()->find('app:load-project');

        $greetInput = new ArrayInput([]);
        $command->run($greetInput, $output);

        $command = $this->getApplication()->find('app:load-issues');

        $greetInput = new ArrayInput([]);
        $command->run($greetInput, $output);

        $command = $this->getApplication()->find('app:load-worklogs');

        $greetInput = new ArrayInput([]);
        $command->run($greetInput, $output);
    }
}