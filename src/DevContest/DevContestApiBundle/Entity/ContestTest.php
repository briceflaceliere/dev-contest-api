<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContestTest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\ContestTestRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class ContestTest
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
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="contestTests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $contest;

    /**
     * @ORM\ManyToOne(targetEntity="Test", inversedBy="contestTests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $test;

    /**
     * @ORM\OneToMany(targetEntity="UserContestTest", mappedBy="dc_contest_test_id")
     */
    protected $userContestTests;

    /**
     * @ORM\OneToOne(targetEntity="ContestTest", inversedBy="previousContestTest")
     * @ORM\JoinColumn(referencedColumnName="dc_id", nullable=true)
     */
    protected $nextContestTest;

    /**
     * @ORM\OneToOne(targetEntity="ContestTest", mappedBy="nextContestTest")
     */
    protected $previousContestTest;

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
     * @return ContestTest
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
     * @return ContestTest|null
     */
    public function getNextContestTest()
    {
        return $this->nextContestTest;
    }

    /**
     * @param ContestTest $nextContestTest
     * @return $this
     */
    public function setNextContestTest(ContestTest $nextContestTest)
    {
        $this->nextContestTest = $nextContestTest;

        return $this;
    }

    /**
     * @return ContestTest|null
     */
    public function getPreviousContestTest()
    {
        return $this->previousContestTest;
    }
}
