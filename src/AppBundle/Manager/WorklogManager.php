<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 14/11/17
 * Time: 23:13
 */

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Worklog;
use JiraRestApi\Issue\IssueService;

class WorklogManager
{
    private $em;
    private $issueManager;
    private $issueService;
    const SECONDS_PER_HOUR = 3600;

    /**
     * WorklogManager constructor.
     * @param EntityManager $em
     * @param IssueService $issueService
     */
    public function __construct(EntityManager $em, IssueManager $issueManager, IssueService $issueService)
    {
        $this->em = $em;
        $this->issueManager = $issueManager;
        $this->issueService = $issueService;
    }

    public function save(){
        $issues = $this->issueManager->findAll();
        foreach($issues as $issue){
            $worklogs = $this->issueService->getWorklog($issue->getCode());
            foreach($worklogs->worklogs as $item){
                $worklog = $this->createWorklog();
                $worklog = $this->setWorklogData($worklog, $item);
                $this->em->persist($worklog);
            }
            $this->em->flush();
        }
    }

    /**
     * @param $worklog
     * @param $item
     * @return mixed
     */
    private function setWorklogData($worklog, $item){
        $this->setJiraId($worklog, $item);
        $this->setIssue($worklog, $item);
        $this->setEmployee($worklog, $item);
        $this->setDate($worklog, $item);
        $this->setTimespent($worklog, $item);

        return $worklog;
    }

    /**
     * @param $worklog
     * @param $item
     */
    private function setJiraId($worklog, $item){
        $worklog->setJiraId($item->id);
    }

    /**
     * @param $worklog
     * @param $item
     */
    private function setIssue($worklog, $item){
        if(!is_null($item->issueId)){
            $issue = $this->issueManager->findOneByJiraId($item->issueId);
            $worklog->setIssue($issue);
        }
    }

    /**
     * @param $worklog
     * @param $item
     */
    private function setEmployee($worklog, $item)
    {
        $worklog->setEmployee($item->author->key);
    }

    /**
     * @param $worklog
     * @param $item
     */
    private function setDate($worklog, $item)
    {
        $worklog->setDate(new \DateTime($item->created));
    }

    /**
     * @param $worklog
     * @param $item
     */
    private function setTimespent($worklog, $item)
    {
        $worklog->setTimespent($item->timeSpentSeconds / self::SECONDS_PER_HOUR);
    }

    /**
     * @return Worklog
     */
    private function createWorklog(){
        return new Worklog();
    }
}