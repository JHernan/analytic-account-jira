<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 21/11/17
 * Time: 19:35
 */

namespace AppBundle\Handler;

use AppBundle\Manager\IssueManager;
use AppBundle\Manager\VersionManager;

class AccountHandler
{
    private $versionManager;
    private $issueManager;

    /**
     * AccountHandler constructor.
     * @param \AppBundle\Manager\VersionManager $versionManager
     */
    public function __construct(VersionManager $versionManager, IssueManager $issueManager)
    {
        $this->versionManager = $versionManager;
        $this->issueManager = $issueManager;
    }

    /**
     * @return mixed
     */
    public function getAccounts(){
        return $this->versionManager->getCostByVersion();
    }

    /**
     * @param $id
     * @return array
     */
    public function getAccountDetail($id){
        $accountDetail = [
            'account' => $this->versionManager->findOneById($id),
            'issues' => $this->issueManager->getCostDetailOfVersion($id)
        ];

        return $accountDetail;
    }
}