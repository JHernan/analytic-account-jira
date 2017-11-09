<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 13:07
 */

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\ComponentManager;

class ComponentManagerTest extends TestCase
{
    public function testCreateComponent(){
        $em = $this->createMock(EntityManager::class);

        $em->expects($this->exactly(2))
            ->method('persist');

        $em->expects($this->exactly(1))
            ->method('flush');

        $componentManager = new ComponentManager($em, 'MTC');

        $components = array(
            'c1' => (object) array('id' => '1', 'name' => 'Name1'),
            'c2' => (object) array('id' => '2', 'name' => 'Name2')
        );

        $componentManager->save($components);
    }
}