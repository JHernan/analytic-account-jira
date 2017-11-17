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
            // TODO
            $worklogs = $this->issueService->getWorklog($issue->getCode());
            foreach($worklogs->worklogs as $item){
                $worklog = $this->createWorklog();
                // TODO
                $worklog = $this->setWorklogData($worklog, $item);
                $this->em->persist($worklog);
            }
        }
        $this->em->flush();
    }

    /**
     * @param $worklog
     * @param $item
     * @return mixed
     */
    private function setWorklogData($worklog, $item){
        $worklog->setJiraId($item->id);
        $worklog->setEmployee($item->author->key);
        $worklog->setDate(new \DateTime($item->created));
        $worklog->setTimespent($item->timeSpentSeconds);

        return $worklog;
    }

    /**
     * @return Worklog
     */
    private function createWorklog(){
        return new Worklog();
    }
}