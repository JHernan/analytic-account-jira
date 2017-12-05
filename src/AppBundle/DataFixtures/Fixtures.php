<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 30/11/17
 * Time: 22:58
 */

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;
use AppBundle\Entity\Issue;
use AppBundle\Entity\Worklog;
use AppBundle\Entity\IssueType;
use AppBundle\Entity\Version;
use AppBundle\Entity\Component;
use AppBundle\Entity\Project;

class Fixtures extends Fixture
{
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);

        $this->loadProjects();
        $this->loadComponents();
        $this->loadVersions();
        $this->loadIssueType();
        $this->loadIssues();
        $this->loadWorklogs();
    }

    private function loadProjects(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/project.yml'));
        
        foreach($items as $item){
            $project = new Project();
            $project->setJiraId($item['jiraId']);
            $project->setName($item['name']);
            $project->setShort($item['short']);
            $this->manager->persist($project);
        }

        $this->manager->flush();
    }

    private function loadComponents(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/component.yml'));

        foreach($items as $item){
            $component = new Component();
            $component->setJiraId($item['jiraId']);
            $component->setName($item['name']);
            $this->manager->persist($component);
        }

        $this->manager->flush();
    }
    
    private function loadVersions(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/version.yml'));

        foreach($items as $item){
            $version = new Version();
            $version->setJiraId($item['jiraId']);
            $version->setName($item['name']);
            $this->manager->persist($version);
        }

        $this->manager->flush();
    }

    private function loadIssueType(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/issue_type.yml'));

        foreach($items as $item){
            $version = new IssueType();
            $version->setJiraId($item['jiraId']);
            $version->setName($item['name']);
            $this->manager->persist($version);
        }

        $this->manager->flush();
    }

    private function loadIssues(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/issue.yml'));
        $i=0;

        foreach($items as $item){
            $i++;
            $version = $this->manager->getRepository('AppBundle:Version')->findOneBy(['name' => $item['version']]);
            $component = $this->manager->getRepository('AppBundle:Component')->findOneBy(['name' => $item['component']]);
            $issue = new Issue();
            $issue->setJiraId($i);
            $issue->setCode('MTC-' . $i);
            $issue->setSummary('Issue '. $i);
            $issue->setTimespent($i * 3600 * 10);
            $issue->setStatus('Open');
            $issue->setVersions([$version]);
            $issue->setComponents([$component]);

            $this->manager->persist($issue);
        }

        $this->manager->flush();
    }

    private function loadWorklogs(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/worklog.yml'));
        $issues = $this->manager->getRepository('AppBundle:Issue')->findAll();

        foreach($issues as $issue){
            $i=0;
            foreach($items as $item){
                $i++;
                $worklog = new Worklog();
                $worklog->setJiraId($i);
                $worklog->setDate(new \DateTime());
                $worklog->setEmployee($item['employee']);
                $worklog->setTimeSpent($issue->getJiraId() * 3600 * $i);
                $worklog->setIssue($issue);

                $this->manager->persist($worklog);
            }
        }

        $this->manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function setManager(ObjectManager $manager){
        $this->manager = $manager;
    }
}