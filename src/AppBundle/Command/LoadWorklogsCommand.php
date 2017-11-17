<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 17/11/17
 * Time: 17:25
 */

namespace AppBundle\Command;

use AppBundle\Handler\WorklogHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadWorklogsCommand extends ContainerAwareCommand
{

    private $worklogHandler;

    public function __construct(WorklogHandler $worklogHandler, $name = null)
    {
        $this->worklogHandler = $worklogHandler;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('app:load-worklogs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->worklogHandler->save();

        $output->writeln('<info>Worklogs successfully loaded!</info>');
    }
}