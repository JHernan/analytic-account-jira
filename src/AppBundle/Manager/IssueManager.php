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
    private $issueTypeManager;

    /**
     * IssueManager constructor.
     * @param EntityManager $em
     * @param IssueTypeManager $issueTypeManager
     */
    public function __construct(EntityManager $em, IssueTypeManager $issueTypeManager)
    {
        $this->em = $em;
        $this->issueTypeManager = $issueTypeManager;
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
        $this->setIssueType($issue, $item);
        $this->setSummary($issue, $item);
        $this->setTimespent($issue, $item);
        $this->setStatus($issue, $item);

        return $issue;
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setSummary($issue, $item){
        $issue->setSummary($item->fields->summary);
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setTimespent($issue, $item){
        $issue->setTimespent($item->fields->timespent);
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setStatus($issue, $item)
    {
        $issue->setStatus($item->fields->status->name);
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setIssueType($issue, $item){
        $issueTypes = $this->issueTypeManager->findAll();
        foreach($issueTypes as $issueType){
            if($issueType->getJiraId() == $item->fields->issuetype->id){
                $issue->setType($issueType);
                break;
            }
        }
    }

    /**
     * @return Issue
     */
    private function createIssue(){
        return new Issue();
    }
}