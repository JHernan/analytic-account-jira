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
    public function getIssues(){
        $issues = [];
        $jql = 'project = MTC order by key ASC';

        $startAt = 0;	    //the index of the first issue to return (0-based)
        $maxResult = 100;	// the maximum number of issues to return (defaults to 50).

        $ret = $this->issueService->search($jql, $startAt, $maxResult);
        $totalCount = $ret->total;
        $issues = $this->combine($issues, $ret);
return $issues;
        $page = $totalCount / $maxResult;

        for ($currentPage = 1; $currentPage < $page; $currentPage++)
        {
            $startAt += $maxResult;
            $ret = $this->issueService->search($jql, $startAt, $maxResult);

            $issues = $this->combine($issues, $ret);
        }

        return $issues;
    }

    public function save(){
        $issues = $this->getIssues();
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