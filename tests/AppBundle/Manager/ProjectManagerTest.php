<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 10/11/17
 * Time: 17:56
 */

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\ProjectManager;

class ProjectManagerTest extends TestCase
{
    public function testSaveIssue()
    {
        $em = $this->createMock(EntityManager::class);

        $em->expects($this->once())
            ->method('persist');

        $em->expects($this->once())
            ->method('flush');

        $projectManager = new ProjectManager($em, 'MTC');

        $project = (object) array('id' => 1, 'name' => 'Name1', 'key' => 'MTC1');

        $projectManager->save($project);
    }
}