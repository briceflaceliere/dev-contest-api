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
 *     @ORM\UniqueConstraint(name="conteststep_test_contest_idx", columns={"dc_test_id", "dc_contest_id"})
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
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="contestSteps")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     *
     */
    protected $contest;

    /**
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="contestSteps")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     *
     * @JMS\Expose
     * @JMS\Type("DevContest\DevContestApiBundle\Entity\Test")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    protected $test;

    /**
     * @ORM\OneToMany(targetEntity="UserContestTest", mappedBy="contestStep")
     */
    protected $userContestTests;

    /**
     * @ORM\OneToOne(targetEntity="ContestStep", mappedBy="previousContestStep")
     *
     * @Assert\Type(type="integer")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    protected $nextContestStep;

    /**
     * @ORM\OneToOne(targetEntity="ContestStep", inversedBy="nextContestStep")
     * @ORM\JoinColumn(referencedColumnName="dc_id", nullable=true, unique=true, onDelete="CASCADE")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     *
     * @Assert\Type(type="integer")
     */
    protected $previousContestStep;

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
     * Get test
     *
     * @return Contest
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set test
     *
     * @param Test $test
     * @return $this
     */
    public function setTest(Test $test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserContestTests()
    {
        return $this->userContestTests;
    }

    /**
     * Set contest test
     *
     * @param ArrayCollection $userContestTests
     * @return $this
     */
    public function setUserContestTests(ArrayCollection $userContestTests)
    {
        $this->userContestTests = $userContestTests;

        return $this;
    }

    /**
     * Add contest test
     *
     * @param UserContestTest $userContestTest
     * @return $this
     */
    public function addUserContestTest(UserContestTest $userContestTest)
    {
        $this->userContestTests->add($userContestTest);

        return $this;
    }

    /**
     * @return ContestStep|null
     */
    public function getNextContestStep()
    {
        return $this->nextContestStep;
    }


    /**
     * @return ContestStep|null
     */
    public function getPreviousContestStep()
    {
        return $this->previousContestStep;
    }

    /**
     * @param ContestStep $previousContestStep
     * @return $this
     */
    public function setPreviousContestStep(ContestStep $previousContestStep = null)
    {
        $this->previousContestStep = $previousContestStep;

        return $this;
    }
}
