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

class VersionManagerTest extends TestCase
{
    private $em;
    private $repository;
    private $versionManager;

    public function __construct($name = null, array $data = [], $dataName = '')
    {

        $this->em = $this->createMock(EntityManager::class);

        $this->repository = $this->getMockBuilder('AppBundle\Repository\VersionRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->versionManager = new VersionManager($this->em);

        parent::__construct($name, $data, $dataName);
    }

    public function testSave(){
        $em = $this->createMock(EntityManager::class);

        $em->expects($this->exactly(2))
            ->method('persist');

        $em->expects($this->once())
            ->method('flush');

        $versionManager = new VersionManager($em, 'MTC');

        $versions = array(
            'v1' => (object) array('id' => '1', 'name' => 'Name1'),
            'v2' => (object) array('id' => '2', 'name' => 'Name2')
        );

        $versionManager->save($versions);
    }

    public function testFindAll(){
        $this->repository->expects($this->once())
            ->method('findAll');

        $this->em->expects($this->once())
            ->method('getRepository')
            ->with('AppBundle:Version')
            ->willReturn($this->repository);

        $this->versionManager->findAll();
    }

    public function testGetTimespentByVersion(){
        $this->repository->expects($this->once())
            ->method('getTimespentByVersion');

        $this->em->expects($this->once())
            ->method('getRepository')
            ->with('AppBundle:Version')
            ->willReturn($this->repository);

        $this->versionManager->getTimespentByVersion();
    }
}