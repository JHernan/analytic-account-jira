<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Issue;

class IssueController extends Controller
{
    /**
     * @Route("/", name="issues")
     */
    public function listAction(Request $request)
    {
        $page = 1;
        $limit = 100;

        $em = $this->getDoctrine();
        $issues = $em->getRepository(Issue::class)->findAll($page, $limit);


        // You can also call the count methods (check PHPDoc for `paginate()`)
        # Total fetched (ie: `5` posts)
        $totalIssuesReturned = $issues->getIterator()->count();

        # Count of ALL posts (ie: `20` posts)
        $totalIssues = $issues->count();

        # ArrayIterator
        $iterator = $issues->getIterator();
        $maxPages = ceil($issues->count() / $limit);
        $firstElement = $page * $limit - $limit + 1;
        $lastElement = $firstElement + $limit - 1;

        return $this->render('issue/list.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'issues' => $issues,
            'maxPages' => $maxPages,
            'page' => $page,
            'totalIssues' => $totalIssues,
            'totalIssuesReturned' => $totalIssuesReturned,
            'firstElement' => $firstElement,
            'lastElement' => $lastElement
        ]);
    }
}
