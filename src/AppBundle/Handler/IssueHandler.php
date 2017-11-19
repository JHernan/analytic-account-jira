<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 20:27
 */

namespace AppBundle\Handler;


use AppBundle\Manager\IssueManager;
use JiraRestApi\Issue\IssueService;

class IssueHandler
{
    const JQL_ISSUES = 'project = MTC AND issuetype in (Bug, Story, Task) ORDER BY key ASC';
    const JQL_SUBTASKS = 'project = MTC AND issuetype = Sub-task order by key ASC';

    private $issueManager;
    private $issueService;

    public function __construct(IssueManager $issueManager, IssueService $issueService)
    {
        $this->issueManager = $issueManager;
        $this->issueService = $issueService;
    }

    /**
     * @return array
     */
    public function getIssues($jql){
        $startAt = 0;
        $maxResult = 100;

        $ret = $this->issueService->search($jql, $startAt, $maxResult);
        $totalCount = $ret->total;
        $issues = $this->combine([], $ret);
//return $issues;
        $page = $totalCount / $maxResult;

        for ($currentPage = 1; $currentPage < $page; $currentPage++)
        {
            $startAt += $maxResult;
            $ret = $this->issueService->search($jql, $startAt, $maxResult);

            $issues = $this->combine($issues, $ret);
        }

        return $issues;
    }

    public function saveIssues(){
        $issues = $this->getIssues(self::JQL_ISSUES);
        $this->issueManager->save($issues);
    }

    public function saveSubTasks(){
        $issues = $this->getIssues(self::JQL_SUBTASKS);
        $this->issueManager->save($issues);
    }

    /**
     * @param $page
     * @param $limit
     * @return array
     */
    public function findAllWithPagination($page, $limit){
        return $this->issueManager->findAllWithPagination($page, $limit);
    }

    /**
     * @param $issues
     * @param $ret
     * @return array
     */
    private function combine($issues, $ret): array
    {
        $issues = array_merge($issues, $ret->issues);
        return $issues;
    }
}