<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 17/11/17
 * Time: 18:56
 */

use PHPUnit\Framework\TestCase;
use AppBundle\Handler\WorklogHandler;
use AppBundle\Manager\WorklogManager;

class WorklogHandlerTest extends TestCase
{
    public function testSaveWorklogs(){
        $worklogManager = $this->createMock(WorklogManager::class);
        $worklogManager->expects($this->once())
            ->method('save');

        $worklogHandler = new WorklogHandler($worklogManager);
        $worklogHandler->save();
    }
}