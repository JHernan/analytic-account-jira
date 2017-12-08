<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 14/11/17
 * Time: 21:05
 */

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\AbstractQuery;

class IssueRepositoryTest extends TestCase
{
    private $queryBuilder;
    private $repository;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        parent::__construct($name, $data, $dataName);
    }

    public function testFindAllWithPagination(){
        $this->repository = $this->getMockBuilder('AppBundle\Repository\IssueRepository')
            ->disableOriginalConstructor()
            ->setMethodsExcept([
                'findAllWithPagination',
            ])
            ->getMock();

        $this->repository->expects($this->once())
            ->method('createQueryBuilder')
            ->with($this->equalTo('i'))
            ->will($this->returnValue($this->queryBuilder));

        $this->repository->findAllWithPagination();
    }

    public function testGetCostDetailOfVersion(){
        $id = 1;

        $this->repository = $this->getMockBuilder('AppBundle\Repository\IssueRepository')
            ->disableOriginalConstructor()
            ->setMethodsExcept([
                'getCostDetailOfVersion',
            ])
            ->getMock();

        $getQuery = $this->getMockBuilder(AbstractQuery::class)
            ->setMethods(array('getResult'))
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->repository->expects($this->once())
            ->method('createQueryBuilder')
            ->with($this->equalTo('i'))
            ->will($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('select')
            ->with('i.code', 'i.summary', 'sum(w.timeSpent * s.costPerHour) as cost')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(1))
            ->method('leftJoin')
            ->with('i.versions', 'v')
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

        $this->queryBuilder->expects($this->at(5))
            ->method('where')
            ->with('v.id = :id')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(6))
            ->method('andWhere')
            ->with('MONTH(w.date) = s.month')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->at(7))
            ->method('andWhere')
            ->with('YEAR(w.date) = s.year')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('groupBy')
            ->with('i.code', 'i.summary')
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('id', $id)
            ->willReturn($this->returnValue($this->queryBuilder));

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($getQuery));

        $getQuery->expects($this->once())
            ->method('getResult')
            ->will($this->returnValue([]));

        $this->repository->getCostDetailOfVersion($id);
    }
}