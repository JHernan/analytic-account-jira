<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 21:29
 */

namespace AppBundle\Command;

use AppBundle\Handler\IssueHandler;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadIssuesCommand extends ContainerAwareCommand
{
    private $issueHandler;

    public function __construct(IssueHandler $issueHandler, $name = null)
    {
        $this->issueHandler = $issueHandler;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('app:load-issues');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->issueHandler->saveIssues();
        $output->writeln('<info>Issues successfully loaded!</info>');

        $this->issueHandler->saveSubTasks();
        $output->writeln('<info>SubTasks successfully loaded!</info>');
    }
}