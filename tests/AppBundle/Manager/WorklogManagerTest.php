<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 17/11/17
 * Time: 19:01
 */

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\WorklogManager;
use AppBundle\Manager\IssueManager;
use JiraRestApi\Issue\IssueService;
use AppBundle\Entity\Issue;

class WorklogManagerTest extends TestCase
{
    public function testSave(){
        $em = $this->createMock(EntityManager::class);
        $issueManager = $this->createMock(IssueManager::class);
        $issueService = $this->createMock(IssueService::class);

        $em->expects($this->exactly(4))
            ->method('persist');

        $em->expects($this->exactly(2))
            ->method('flush');

        $issue1 = new Issue();
        $issue1->setCode('Code1');
        $issue2 = new Issue();
        $issue2->setCode('Code2');

        $issues = [
            $issue1, $issue2
        ];

        $issueManager->expects($this->once())
            ->method('findAll')
            ->willReturn($issues);

        $worklogs = (object) array(
            'worklogs' => (object) array(
                'w1' => (object) array('id' => '1', 'author' => (object) array('key' => 'employee1'), 'created' => '2017-01-01 00:00:00', 'timeSpentSeconds' => '3600', 'issueId' => '1'),
                'w2' => (object) array('id' => '2', 'author' => (object) array('key' => 'employee2'), 'created' => '2017-01-01 00:00:00', 'timeSpentSeconds' => '3600', 'issueId' => '2')
            )
        );

        $issueService->expects($this->exactly(2))
            ->method('getWorklog')
            ->willReturn($worklogs);

        $worklogManager = new WorklogManager($em, $issueManager, $issueService);

        $worklogManager->save($worklogs);
    }
}