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
use AppBundle\Command\LoadProjectCommand;
use AppBundle\Handler\ProjectHandler;

class LoadProjectCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $projectHandler = $this->createMock(ProjectHandler::class);

        $projectHandler->expects($this->once())
            ->method('save');

        $application->add(new LoadProjectCommand($projectHandler));

        $command = $application->find('app:load-project');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName()
        ));

        $output = $commandTester->getDisplay();
        $this->assertContains('Project successfully loaded!', $output);
    }
}