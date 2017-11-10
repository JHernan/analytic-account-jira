<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 19:03
 */

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\IssueTypeManager;

class IssueTypeManagerTest extends TestCase
{
    public function testSaveIssueType(){
        $em = $this->createMock(EntityManager::class);

        $em->expects($this->exactly(2))
            ->method('persist');

        $em->expects($this->once())
            ->method('flush');

        $issueTypeManager = new IssueTypeManager($em, 'MTC');

        $issueTypes = array(
            'it1' => (object) array('id' => '1', 'name' => 'Name1'),
            'it2' => (object) array('id' => '2', 'name' => 'Name2')
        );

        $issueTypeManager->save($issueTypes);
    }
}