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
 * @Route("/")
 */
class AccountController extends Controller
{
    /**
     * @Route("/", name="accounts")
     */
    public function accountsAction(){
        $accountHandler = $this->get(AccountHandler::class);
        $accounts = $accountHandler->getAccounts();

        return $this->render('analyticAccount/accounts.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'accounts' => $accounts
        ]);
    }

    /**
     * @Route("/{id}/", requirements={"id" = "\d+"}, name="account_detail")
     */
    public function accountDetailAction($id){
        $accountHandler = $this->get(AccountHandler::class);
        $accountDetail = $accountHandler->getAccountDetail($id);

        return $this->render('analyticAccount/accountDetail.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'account' => $accountDetail['account'],
            'issues' => $accountDetail['issues']
        ]);
    }
}