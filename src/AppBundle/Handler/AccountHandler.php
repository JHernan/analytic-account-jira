<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 21/11/17
 * Time: 19:35
 */

namespace AppBundle\Handler;

use AppBundle\Manager\VersionManager;

class AccountHandler
{
    private $versionManager;

    /**
     * AccountHandler constructor.
     * @param \AppBundle\Manager\VersionManager $versionManager
     */
    public function __construct(VersionManager $versionManager)
    {
        $this->versionManager = $versionManager;
    }

    public function getAccounts(){
        return $this->versionManager->getTimespentByVersion();
    }
}