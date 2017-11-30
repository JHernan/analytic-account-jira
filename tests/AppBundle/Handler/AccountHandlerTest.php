<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 30/11/17
 * Time: 20:18
 */

use PHPUnit\Framework\TestCase;
use AppBundle\Handler\AccountHandler;
use AppBundle\Manager\VersionManager;

class AccountHandlerTest extends TestCase
{
    public function testGetAccounts(){
        $versionManager = $this->createMock(VersionManager::class);

        $versionManager->expects($this->once())
            ->method('getTimespentByVersion');

        $accountHandler = new AccountHandler($versionManager);
        $accountHandler->getAccounts();
    }
}