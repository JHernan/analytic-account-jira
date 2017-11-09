<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 21:29
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class loadIssuesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:load-issues');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // ...

        $issueHandler = $this->getContainer()->get('AppBundle\Handler\IssueHandler');
        $issueHandler->save();

        $output->writeln('User successfully generated!');
    }
}