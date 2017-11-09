<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 19:01
 */

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\IssueType;

class IssueTypeManager
{
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $issueTypes
     */
    public function save($issueTypes){
        foreach($issueTypes as $item){
            $issueType = $this->createIssueType();
            $issueType = $this->setIssueTypeData($issueType, $item);
            $this->em->persist($issueType);
        }
        $this->em->flush();
    }

    /**
     * @param $IssueType
     * @param $item
     * @return mixed
     */
    private function setIssueTypeData($IssueType, $item){
        $IssueType->setJiraId($item->id);
        $IssueType->setName($item->name);

        return $IssueType;
    }

    /**
     * @return IssueType
     */
    private function createIssueType(){
        return new IssueType();
    }
}