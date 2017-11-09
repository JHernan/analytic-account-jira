<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 11:21
 */

use PHPUnit\Framework\TestCase;
use AppBundle\Manager\ProjectManager;

class ProjectManagerTest extends TestCase
{
    public function testGetProject(){
        $componentManager = $this->createMock(\AppBundle\Manager\ComponentManager::class);
        $versionManager = $this->createMock(\AppBundle\Manager\VersionManager::class);
        $projectService = $this->createMock(\JiraRestApi\Project\ProjectService::class);
        $projectService->expects($this->exactly(1))
            ->method('get')
            ->with('MTC');

        $projectManager = new ProjectManager($componentManager, $versionManager, $projectService, 'MTC');
        $projectManager->getProject();
    }
}