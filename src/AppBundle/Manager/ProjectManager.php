<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 8/11/17
 * Time: 20:07
 */

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use JiraRestApi\Project\ProjectService;
use AppBundle\Entity\Component;


class ProjectManager
{
    private $em;
    private $key;

    public function __construct(EntityManager $em, $key)
    {
        $this->em = $em;
        $this->key = $key;
    }

    public function save(){
        $project = $this->getProject($this->key);

        $this->saveComponents($project);
    }

    public function getProject(){
        $projectService = new ProjectService();

        return $projectService->get($this->key);
    }

    public function saveComponents($project){
        foreach($project->components as $item){
            $component = new Component();
            $component->setJiraId($item->id);
            $component->setName($item->name);
            $this->em->persist($component);
        }
        $this->em->flush();
    }
}