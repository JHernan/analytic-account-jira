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
use AppBundle\Manager\IssueManager;

class AccountHandlerTest extends TestCase
{
    private $versionManager;
    private $issueManager;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->versionManager = $this->createMock(VersionManager::class);
        $this->issueManager = $this->createMock(IssueManager::class);

        parent::__construct($name, $data, $dataName);
    }

    public function testGetAccounts(){
        $this->versionManager->expects($this->once())
            ->method('getCostByVersion');

        $accountHandler = new AccountHandler($this->versionManager, $this->issueManager);
        $accountHandler->getAccounts();
    }

    public function testGetAccountDetail(){
        $id = 1;

        $this->versionManager->expects($this->once())
            ->method('findOneById')
            ->with($id);

        $this->issueManager->expects($this->once())
            ->method('getCostDetailOfVersion')
            ->with($id);

        $accountHandler = new AccountHandler($this->versionManager, $this->issueManager);
        $result = $accountHandler->getAccountDetail($id);

        $this->assertArrayHasKey('account', $result);
        $this->assertArrayHasKey('issues', $result);
    }
}