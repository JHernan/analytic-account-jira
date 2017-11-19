<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 10/11/17
 * Time: 16:50
 */

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use AppBundle\Command\LoadIssuesCommand;
use AppBundle\Handler\IssueHandler;

class LoadIssuesCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $issueHandler = $this->createMock(IssueHandler::class);

        $issueHandler->expects($this->once())
            ->method('saveIssues');

        $issueHandler->expects($this->once())
            ->method('saveSubTasks');

        $application->add(new LoadIssuesCommand($issueHandler));

        $command = $application->find('app:load-issues');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName()
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Issues successfully loaded!', $output);
    }
}