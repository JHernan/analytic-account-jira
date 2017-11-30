<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 19/11/17
 * Time: 20:56
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Handler\AccountHandler;

/**
 * @Route("/analytic-account")
 */
class AccountController extends Controller
{
    /**
     * @Route("/", name="analytic_account")
     */
    public function indexAction(){
        $issueHandler = $this->get(AccountHandler::class);
        $accounts = $issueHandler->getAccounts();

        return $this->render('analyticAccount/account.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'accounts' => $accounts
        ]);
    }
}