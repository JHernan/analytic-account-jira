<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 10/11/17
 * Time: 17:30
 */

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\IssueManager;
use AppBundle\Manager\IssueTypeManager;

class IssueManagerTest extends TestCase
{
    public function testSaveIssue(){
        $em = $this->createMock(EntityManager::class);
        $issueTypeManager = $this->createMock(IssueTypeManager::class);
        $componentManager = $this->createMock(\AppBundle\Manager\ComponentManager::class);

        $em->expects($this->exactly(2))
            ->method('persist');

        $em->expects($this->once())
            ->method('flush');

        $issueTypeManager->expects($this->exactly(2))
            ->method('findAll')
            ->willReturn([]);

        $componentManager->expects($this->exactly(2))
            ->method('findAll')
            ->willReturn([]);

        $issueManager = new IssueManager($em, $issueTypeManager, $componentManager);

        $issues = array(
            'i1' => (object) array(
                'fields' => (object) array(
                    'id' => '1',
                    'summary' => 'Summary1',
                    'timespent' => '1',
                    'status' => (object) array(
                        'id' => '1',
                        'name' => 'To do'
                    ),
                    'components' => array(
                        'id' => '1',
                        'name' => 'Component'
                    )
                )
            ),
            'i2' => (object) array(
                'fields' => (object) array(
                    'id' => '2',
                    'summary' => 'Symmary2',
                    'timespent' => '2',
                    'status' => (object) array(
                        'name' => 'To do'
                    ),
                    'components' => array(
                        'id' => '2',
                        'name' => 'Component'
                    )
                )
            )
        );

        $issueManager->save($issues);
    }
}