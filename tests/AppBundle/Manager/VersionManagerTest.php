<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 18:45
 */

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\VersionManager;

class VersionManagerTest
{
    public function testCreateVersion(){
        $em = $this->createMock(EntityManager::class);

        $em->expects($this->exactly(2))
            ->method('persist');

        $em->expects($this->exactly(1))
            ->method('flush');

        $versionManager = new VersionManager($em, 'MTC');

        $versions = array(
            'c1' => (object) array('id' => '1', 'name' => 'Name1'),
            'c2' => (object) array('id' => '2', 'name' => 'Name2')
        );

        $versionManager->save($versions);
    }
}