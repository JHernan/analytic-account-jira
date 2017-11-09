<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 8/11/17
 * Time: 20:07
 */

namespace AppBundle\Manager;


use AppBundle\Manager\ComponentManager;
use AppBundle\Manager\VersionManager;
use AppBundle\Manager\IssueTypeManager;
use JiraRestApi\Project\ProjectService;


class ProjectManager
{
    private $componentManager;
    private $versionManager;
    private $issueTypeManager;
    private $projectService;
    private $key;

    /**
     * ProjectManager constructor.
     * @param \AppBundle\Manager\ComponentManager $componentManager
     * @param ProjectService $projectService
     * @param $key
     */
    public function __construct(ComponentManager $componentManager, VersionManager $versionManager, IssueTypeManager $issueTypeManager, ProjectService $projectService, $key)
    {
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

        $this->saveComponents($project->components);
        $this->saveVersions($project->versions);
        $this->saveIssueTypes($project->issueTypes);
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