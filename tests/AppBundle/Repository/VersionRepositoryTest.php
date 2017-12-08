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

    public function testGetCostByVersion(){
        $this->queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = $this->getMockBuilder('AppBundle\Repository\VersionRepository')
            ->disableOriginalConstructor()
            ->setMethodsExcept([
                'getCostByVersion',
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
            ->with('v.id', 'v.name', 'sum(w.timeSpent * s.costPerHour) as cost')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(1))
            ->method('leftJoin')
            ->with('v.issues', 'i')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(2))
            ->method('leftJoin')
            ->with('i.worklogs', 'w')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(3))
            ->method('leftJoin')
            ->with('w.employee', 'e')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(4))
            ->method('leftJoin')
            ->with('e.salaries', 's')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('where')
            ->with('MONTH(w.date) = s.month')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('andWhere')
            ->with('YEAR(w.date) = s.year')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('groupBy')
            ->with('v.id', 'v.name')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($getQuery));

        $getQuery->expects($this->once())
            ->method('getResult')
            ->will($this->returnValue([]));

        $this->repository->getCostByVersion();
    }
}