<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 9/11/17
 * Time: 20:38
 */

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Issue;

class IssueManager
{
    private $em;
    private $issueTypeManager;
    private $componentManager;

    /**
     * IssueManager constructor.
     * @param EntityManager $em
     * @param IssueTypeManager $issueTypeManager
     * @param ComponentManager $componentManager
     */
    public function __construct(EntityManager $em, IssueTypeManager $issueTypeManager, ComponentManager $componentManager)
    {
        $this->em = $em;
        $this->issueTypeManager = $issueTypeManager;
        $this->componentManager = $componentManager;
    }

    /**
     * @param $issues
     */
    public function save($issues){
        foreach($issues as $item){
            $issue = $this->createIssue();
            $issue = $this->setIssueData($issue, $item);
            $this->em->persist($issue);
        }
        $this->em->flush();
    }

    /**
     * @param $issue
     * @param $item
     * @return mixed
     */
    private function setIssueData($issue, $item){
        $this->setIssueType($issue, $item);
        $this->setComponents($issue, $item);
        $this->setSummary($issue, $item);
        $this->setTimespent($issue, $item);
        $this->setStatus($issue, $item);

        return $issue;
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setSummary($issue, $item){
        $issue->setSummary($item->fields->summary);
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setTimespent($issue, $item){
        $issue->setTimespent($item->fields->timespent);
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setStatus($issue, $item)
    {
        $issue->setStatus($item->fields->status->name);
    }

    /**
     * @param $issue
     * @param $item
     */
    private function setIssueType($issue, $item){
        $issueTypes = $this->issueTypeManager->findAll();
        foreach($issueTypes as $issueType){
            if($issueType->getJiraId() == $item->fields->issuetype->id){
                $issue->setType($issueType);
                break;
            }
        }
    }

    private function setComponents($issue, $item){
        $components = $this->componentManager->findAll();
        $listComponents = [];
        foreach($item->fields->components as $itemComponent){
            foreach($components as $component){
                if($component->getJiraId() == $itemComponent->id){
                    array_push($listComponents, $component);
                }
            }
        }

        $issue->setComponents($listComponents);
    }

    /**
     * @return Issue
     */
    private function createIssue(){
        return new Issue();
    }
}