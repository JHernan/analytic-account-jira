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
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\Yaml\Yaml;
use AppBundle\Entity\Issue;
use AppBundle\Entity\Worklog;
use AppBundle\Entity\IssueType;
use AppBundle\Entity\Version;
use AppBundle\Entity\Component;
use AppBundle\Entity\Project;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Salary;

class Fixtures extends Fixture
{
    private $manager;
    private $userManipulator;

    public function __construct(UserManipulator $userManipulator)
    {
        $this->userManipulator = $userManipulator;
    }

    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);

        $this->loadProjects();
        $this->loadComponents();
        $this->loadVersions();
        $this->loadIssueType();
        $this->loadEmployees();
        $this->loadSalaries();
        $this->loadIssues();
        $this->loadWorklogs();
        $this->loadUsers();
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

    private function loadEmployees(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/employee.yml'));

        foreach($items as $item){
            $employee = new Employee();
            $employee->setName($item['name']);
            $employee->setUsername($item['username']);
            $this->manager->persist($employee);
        }

        $this->manager->flush();
    }

    private function loadSalaries(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/salary.yml'));
        $months = [1,2,3,4,5,6,7,8,9,10,11,12];

        foreach($months as $month){
            foreach($items as $item){
                $employee = $this->manager->getRepository('AppBundle:Employee')->findOneBy(['name' => $item['employee']]);

                $salary = new Salary();
                $salary->setYear('2017');
                $salary->setMonth($month);
                $salary->setAmount($item['amount']);
                $salary->setHours($item['hours']);
                $salary->setEmployee($employee);

                $cost = $salary->getCostPerHour();

                $this->manager->persist($salary);
            }
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
            $issueType = $this->manager->getRepository('AppBundle:IssueType')->findOneBy(['name' => $item['issue_type']]);

            $issue = new Issue();
            $issue->setJiraId($i);
            $issue->setCode('MTC-' . $i);
            $issue->setSummary('Issue '. $i);
            $issue->setTimespent($i * 10);
            $issue->setStatus('Open');
            $issue->setVersions([$version]);
            $issue->setComponents([$component]);
            $issue->setType($issueType);

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
                $employee = $this->manager->getRepository('AppBundle:Employee')->findOneBy(['name' => $item['employee']]);

                $worklog = new Worklog();
                $worklog->setJiraId($i);
                $worklog->setDate(new \DateTime());
                $worklog->setEmployee($employee);
                $worklog->setTimeSpent($issue->getJiraId() * $i);
                $worklog->setIssue($issue);

                $this->manager->persist($worklog);
            }
        }

        $this->manager->flush();
    }

    public function loadUsers(){
        $items = Yaml::parse(file_get_contents(__DIR__. '/user.yml'));

        foreach($items as $item){
            $this->userManipulator->create($item['username'], $item['password'], $item['email'], true, false);
            $this->userManipulator->addRole($item['username'], $item['role']);
        }
    }

    /**
     * @param ObjectManager $manager
     */
    private function setManager(ObjectManager $manager){
        $this->manager = $manager;
    }
}