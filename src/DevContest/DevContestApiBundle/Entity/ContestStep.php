<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * ContestStep
 *
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="contest_step_position_idx", columns={"dc_contest_id", "dc_position"})
 * })
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\ContestStepRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @JMS\ExclusionPolicy("all")
 */
class ContestStep
{

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     *
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"detail"})
     *
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var text
     *
     * @ORM\Column(type="text", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"detail"})
     *
     * @Assert\NotBlank()
     */
    private $statement;

    /**
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="contestSteps")
     * @ORM\JoinColumn(referencedColumnName="dc_id", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     *
     */
    protected $contest;

    /**
     * @ORM\Column(type="integer", nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     *
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(value=0)
     */
    protected $position;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userContestTests = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param text $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return text
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param text $statement
     * @return $this
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;

        return $this;
    }

    /**
     * @return Contest
     */
    public function getContest()
    {
        return $this->contest;
    }

    /**
     * @param Contest $contest
     * @return $this
     */
    public function setContest(Contest $contest)
    {
        $this->contest = $contest;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }


}
