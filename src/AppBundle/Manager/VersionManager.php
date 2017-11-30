<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 18:45
 */

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Version;

class VersionManager
{
    private $em;

    /**
     * VersionManager constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $versions
     */
    public function save($versions){
        foreach($versions as $item){
            $version = $this->createVersion();
            $version = $this->setVersionData($version, $item);
            $this->em->persist($version);
        }
        $this->em->flush();
    }

    /**
     * @return array
     */
    public function findAll(){
        return $this->em->getRepository('AppBundle:Version')->findAll();
    }

    /**
     * @return mixed
     */
    public function getTimespentByVersion(){
        return $this->em->getRepository('AppBundle:Version')->getTimespentByVersion();
    }

    /**
     * @param $version
     * @param $item
     * @return mixed
     */
    private function setVersionData($version, $item){
        $version->setJiraId($item->id);
        $version->setName($item->name);

        return $version;
    }

    /**
     * @return Version
     */
    private function createVersion(){
        return new Version();
    }
}