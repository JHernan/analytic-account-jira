<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Worklog
 *
 * @ORM\Table(name="worklog")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorklogRepository")
 */
class Worklog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="jiraId", type="integer")
     */
    private $jiraId;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="worklogs")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    private $employee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="timeSpent", type="integer")
     */
    private $timeSpent;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Issue", inversedBy="worklogs")
     * @ORM\JoinColumn(name="issue_id", referencedColumnName="id")
     */
    private $issue;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set jiraId
     *
     * @param integer $jiraId
     *
     * @return Worklog
     */
    public function setJiraId($jiraId)
    {
        $this->jiraId = $jiraId;

        return $this;
    }

    /**
     * Get jiraId
     *
     * @return int
     */
    public function getJiraId()
    {
        return $this->jiraId;
    }

    /**
     * Set employee
     *
     * @param mixed $employee
     *
     * @return Worklog
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Worklog
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set timeSpent
     *
     * @param integer $timeSpent
     *
     * @return Worklog
     */
    public function setTimeSpent($timeSpent)
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }

    /**
     * Get timeSpent
     *
     * @return int
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }

    /**
     * @return mixed
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * @param mixed $issue
     */
    public function setIssue($issue)
    {
        $this->issue = $issue;
    }

    /**
     * @return string
     */
    public function __toString(){
        return $this->issue->getCode() .' - ' . $this->timeSpent;
    }
}

