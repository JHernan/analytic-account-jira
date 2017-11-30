<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 27/11/17
 * Time: 20:21
 */

use PHPUnit\Framework\TestCase;

use Doctrine\ORM\AbstractQuery;

class VersionRepositoryTest extends TestCase
{
    private $queryBuilder;
    private $repository;

    public function testGetTimespentByVersion(){
        $this->queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = $this->getMockBuilder('AppBundle\Repository\VersionRepository')
            ->disableOriginalConstructor()
            ->setMethodsExcept([
                'getTimespentByVersion',
            ])
            ->getMock();

        $getQuery = $this->getMockBuilder(AbstractQuery::class)
            ->setMethods(array('getResult'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->repository->expects($this->once())
            ->method('createQueryBuilder')
            ->with($this->equalTo('v'))
            ->will($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('select')
            ->with('v.name', 'sum(w.timeSpent / 3600) as timespent')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(1))
            ->method('leftJoin')
            ->with('v.issues', 'i')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(2))
            ->method('leftJoin')
            ->with('i.worklogs', 'w')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('groupBy')
            ->with('v.name')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($getQuery));

        $getQuery->expects($this->once())
            ->method('getResult')
            ->will($this->returnValue([]));

        $this->repository->getTimespentByVersion();
    }
}