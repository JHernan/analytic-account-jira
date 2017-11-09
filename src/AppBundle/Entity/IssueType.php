<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IssueType
 *
 * @ORM\Table(name="issue_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IssueTypeRepository")
 */
class IssueType
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="type")
     */
    private $issues;


    public function __construct() {
        $this->issues = new ArrayCollection();
    }

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
     * @return IssueType
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
     * Set name
     *
     * @param string $name
     *
     * @return IssueType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

