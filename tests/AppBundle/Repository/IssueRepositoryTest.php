<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 14/11/17
 * Time: 21:05
 */

use PHPUnit\Framework\TestCase;

class IssueRepositoryTest extends TestCase
{
    private $queryBuilder;
    private $repository;

    public function testFindAllWithPagination(){
        $this->queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = $this->getMockBuilder('AppBundle\Repository\IssueRepository')
            ->disableOriginalConstructor()
            ->setMethodsExcept([
                // Insert any overridden/implemented functions here, in your case:
                'findAllWithPagination',
            ])
            ->getMock();

        $this->repository->expects($this->once())
            ->method('createQueryBuilder')
            ->with($this->equalTo('i'))
            ->will($this->returnValue($this->queryBuilder));

        $this->repository->findAllWithPagination();
    }
}