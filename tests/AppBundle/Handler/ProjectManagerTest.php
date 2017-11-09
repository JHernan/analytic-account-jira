<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 11:21
 */

use PHPUnit\Framework\TestCase;
use AppBundle\Handler\ProjectHandler;

class ProjectHandlerTest extends TestCase
{
    public function testGetProject(){
        $projectManager = $this->createMock(\AppBundle\Manager\ProjectManager::class);
        $componentManager = $this->createMock(\AppBundle\Manager\ComponentManager::class);
        $versionManager = $this->createMock(\AppBundle\Manager\VersionManager::class);
        $issueTypeManager = $this->createMock(\AppBundle\Manager\IssueTypeManager::class);
        $projectService = $this->createMock(\JiraRestApi\Project\ProjectService::class);
        $projectService->expects($this->exactly(1))
            ->method('get')
            ->with('MTC');

        $projectManager = new ProjectHandler($projectManager, $componentManager, $versionManager, $issueTypeManager, $projectService, 'MTC');
        $projectManager->getProject();
    }
}