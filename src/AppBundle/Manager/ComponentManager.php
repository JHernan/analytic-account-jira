<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 12:53
 */

namespace AppBundle\Manager;


use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Component;

class ComponentManager
{
    private $em;

    /**
     * ComponentManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $components
     */
    public function save($components){
        foreach($components as $item){
            $component = $this->createComponent();
            $component = $this->setComponentData($component, $item);
            $this->em->persist($component);
        }
        $this->em->flush();
    }

    /**
     * @return array
     */
    public function findAll(){
        return $this->em->getRepository('AppBundle:Component')->findAll();
    }

    /**
     * @param $component
     * @param $item
     * @return mixed
     */
    private function setComponentData($component, $item){
        $component->setJiraId($item->id);
        $component->setName($item->name);

        return $component;
    }

    /**
     * @return Component
     */
    private function createComponent(){
        return new Component();
    }
}