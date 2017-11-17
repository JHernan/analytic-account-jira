<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 17/11/17
 * Time: 18:53
 */

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use AppBundle\Command\LoadWorklogsCommand;
use AppBundle\Handler\WorklogHandler;

class LoadWorklogsCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $worklogHandler = $this->createMock(WorklogHandler::class);

        $worklogHandler->expects($this->once())
            ->method('save');

        $application->add(new LoadWorklogsCommand($worklogHandler));

        $command = $application->find('app:load-worklogs');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName()
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Worklogs successfully loaded!', $output);
    }
}