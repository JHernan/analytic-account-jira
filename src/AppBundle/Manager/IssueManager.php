<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 20:38
 */

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Issue;

class IssueManager
{
    private $em;

    /**
     * IssueManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $issues
     */
    public function save($issues){
        foreach($issues as $item){
            $issue = $this->createIssue();
            $issue = $this->setIssueData($issue, $item);
            $this->em->persist($issue);
        }
        $this->em->flush();
    }

    /**
     * @param $issue
     * @param $item
     * @return mixed
     */
    private function setIssueData($issue, $item){
        $issue->setSummary($item->fields->summary);
        $issue->setTimespent($item->fields->timespent);
        $issue->setStatus($item->fields->status->name);

        return $issue;
    }

    /**
     * @return Issue
     */
    private function createIssue(){
        return new Issue();
    }
}