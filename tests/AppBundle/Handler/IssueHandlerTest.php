<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 20:54
 */

use PHPUnit\Framework\TestCase;
use AppBundle\Handler\IssueHandler;
use AppBundle\Manager\IssueManager;
use JiraRestApi\Issue\IssueService;
use JiraRestApi\Issue\IssueSearchResult;

class IssueHandlerTest extends TestCase
{
    public function testGetIssues(){
        $issueManager = $this->createMock(IssueManager::class);
        $issueService = $this->createMock(IssueService::class);

        $issueResult = new IssueSearchResult();
        $issueResult->total = 100;
        $issueResult->issues = [];

        $jql = 'project = MTC order by key ASC';
        $startAt = 0;
        $maxResult = 100;
        
        $issueService->expects($this->exactly(1))
            ->method('search')
            ->with($jql, $startAt, $maxResult)
            ->willReturn($issueResult);

        $issueHandler = new IssueHandler($issueManager, $issueService);
        $issueHandler->getIssues();
    }
}