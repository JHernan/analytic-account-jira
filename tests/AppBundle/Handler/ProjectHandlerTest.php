<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 11:21
 */

use PHPUnit\Framework\TestCase;
use AppBundle\Handler\ProjectHandler;
use AppBundle\Manager\ProjectManager;
use AppBundle\Manager\ComponentManager;
use AppBundle\Manager\VersionManager;
use AppBundle\Manager\IssueTypeManager;
use JiraRestApi\Project\ProjectService;

class ProjectHandlerTest extends TestCase
{
    public function testGetProject(){
        $projectManager = $this->createMock(ProjectManager::class);
        $componentManager = $this->createMock(ComponentManager::class);
        $versionManager = $this->createMock(VersionManager::class);
        $issueTypeManager = $this->createMock(IssueTypeManager::class);
        $projectService = $this->createMock(ProjectService::class);
        $projectService->expects($this->exactly(1))
            ->method('get')
            ->with('MTC');

        $projectHandler = new ProjectHandler($projectManager, $componentManager, $versionManager, $issueTypeManager, $projectService, 'MTC');
        $projectHandler->getProject();
    }
}