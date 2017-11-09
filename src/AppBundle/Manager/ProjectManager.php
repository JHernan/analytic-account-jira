<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 8/11/17
 * Time: 20:07
 */

namespace AppBundle\Manager;

use AppBundle\Entity\Project;
use Doctrine\ORM\EntityManager;

class ProjectManager{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save($item){
        $project = $this->createProject();
        $project = $this->setProjectData($project, $item);

        $this->em->persist($project);
        $this->em->flush();
    }

    /**
     * @param $project
     * @param $item
     * @return mixed
     */
    private function setProjectData($project, $item){
        $project->setJiraId($item->id);
        $project->setName($item->name);
        $project->setShort($item->key);

        return $project;
    }

    private function createProject(){
        return new Project();
    }
}