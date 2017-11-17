<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 14/11/17
 * Time: 23:17
 */

namespace AppBundle\Handler;

use AppBundle\Manager\WorklogManager;

class WorklogHandler
{
    private $worklogManager;

    public function __construct(WorklogManager $worklogManager)
    {
        $this->worklogManager = $worklogManager;
    }

    public function save(){
        $this->worklogManager->save();
    }
}