<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Handler\IssueHandler;

class IssueController extends Controller
{
    /**
     * @Route("/{page}/{limit}", requirements={"page" = "\d+", "limit" = "\d+"}, defaults={"page" = 1, "limit" = 100}, name="issues")
     */
    public function listAction($page, $limit)
    {
        $issueHandler = $this->get(IssueHandler::class);
        $listIssues = $issueHandler->findWithPagination($page, $limit);

        return $this->render('issue/list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'issues' => $listIssues['issues'],
            'maxPages' => $listIssues['maxPages'],
            'page' => $listIssues['page'],
            'totalIssues' => $listIssues['totalIssues'],
            'totalIssuesReturned' => $listIssues['totalIssuesReturned'],
            'firstElement' => $listIssues['firstElement'],
            'lastElement' => $listIssues['lastElement']
        ]);
    }
}
