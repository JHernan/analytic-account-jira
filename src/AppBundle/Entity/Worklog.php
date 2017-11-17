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
     * @var string
     *
     * @ORM\Column(name="employee", type="string", length=255)
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
     * @param string $employee
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
     * @return string
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
}

