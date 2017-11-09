<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 8/11/17
 * Time: 20:07
 */

namespace AppBundle\Handler;

use AppBundle\Manager\ProjectManager;
use AppBundle\Manager\ComponentManager;
use AppBundle\Manager\VersionManager;
use AppBundle\Manager\IssueTypeManager;
use JiraRestApi\Project\ProjectService;

class ProjectHandler
{
    private $projectManager;
    private $componentManager;
    private $versionManager;
    private $issueTypeManager;
    private $projectService;
    private $key;

    /**
     * ProjectHandler constructor.
     * @param ProjectManager $projectManager
     * @param ComponentManager $componentManager
     * @param VersionManager $versionManager
     * @param IssueTypeManager $issueTypeManager
     * @param ProjectService $projectService
     * @param $key
     */
    public function __construct(ProjectManager $projectManager, ComponentManager $componentManager, VersionManager $versionManager, IssueTypeManager $issueTypeManager, ProjectService $projectService, $key)
    {
        $this->projectManager = $projectManager;
        $this->componentManager = $componentManager;
        $this->versionManager = $versionManager;
        $this->issueTypeManager = $issueTypeManager;
        $this->projectService = $projectService;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getProject(){
        return $this->projectService->get($this->key);
    }

    public function save(){
        $project = $this->getProject($this->key);

        $this->saveProject($project);
        $this->saveComponents($project->components);
        $this->saveVersions($project->versions);
        $this->saveIssueTypes($project->issueTypes);
    }

    /**
     * @param $project
     */
    private function saveProject($project){
        $this->projectManager->save($project);
    }

    /**
     * @param $components
     */
    private function saveComponents($components){
        $this->componentManager->save($components);
    }

    /**
     * @param $versions
     */
    private function saveVersions($versions){
        $this->versionManager->save($versions);
    }

    /**
     * @param $issueTypes
     */
    private function saveIssueTypes($issueTypes){
        $this->issueTypeManager->save($issueTypes);
    }
}