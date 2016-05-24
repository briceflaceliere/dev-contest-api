<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContestStep
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\ContestStepRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class ContestStep
{

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="contestSteps")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $contest;

    /**
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="contestSteps")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $test;

    /**
     * @ORM\OneToMany(targetEntity="UserContestTest", mappedBy="dc_contest_test_id")
     */
    protected $userContestTests;

    /**
     * @ORM\OneToOne(targetEntity="ContestStep", inversedBy="previousContestStep")
     * @ORM\JoinColumn(referencedColumnName="dc_id", nullable=true)
     */
    protected $nextContestStep;

    /**
     * @ORM\OneToOne(targetEntity="ContestStep", mappedBy="nextContestStep")
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
     * Set number
     *
     * @param integer $number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
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
     * @param ContestStep $nextContestStep
     * @return $this
     */
    public function setNextContestStep(ContestStep $nextContestStep)
    {
        $this->nextContestStep = $nextContestStep;

        return $this;
    }

    /**
     * @return ContestStep|null
     */
    public function getPreviousContestStep()
    {
        return $this->previousContestStep;
    }
}
