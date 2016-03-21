<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserContest
 *
 * @ORM\Table(name="dc_user_contest")
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\UserContestRepository")
 */
class UserContest
{
    /**
     * @var integer
     *
     * @ORM\Column(name="dc_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * @var \DateTime
     *
     * @ORM\Column(name="dc_start_ts", type="datetime", nullable=true)
     */
    private $startTs;

    /**
     * Set startTs
     *
     * @param \DateTime $startTs
     *
     * @return UserContest
     */
    public function setStartTs($startTs)
    {
        $this->startTs = $startTs;

        return $this;
    }

    /**
     * Get startTs
     *
     * @return \DateTime
     */
    public function getStartTs()
    {
        return $this->startTs;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dc_end_ts", type="datetime", nullable=true)
     */
    private $endTs;

    /**
     * Set endTs
     *
     * @param \DateTime $endTs
     *
     * @return UserContest
     */
    public function setEndTs($endTs)
    {
        $this->endTs = $endTs;

        return $this;
    }

    /**
     * Get endTs
     *
     * @return \DateTime
     */
    public function getEndTs()
    {
        return $this->endTs;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="dc_score", type="integer", nullable=true)
     */
    private $score;

    /**
     * Set score
     *
     * @param integer $score
     *
     * @return UserContest
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user")
     * @ORM\JoinColumn(name="dc_user_id", referencedColumnName="dc_id")
     */
    protected $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="UserContestTest", mappedBy="dc_user_contest_id")
     */
    protected $userContestTests;


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
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="userContests")
     * @ORM\JoinColumn(name="dc_contest_id", referencedColumnName="dc_id")
     */
    protected $contest;

    /**
     * Get contest
     *
     * @return Contest
     */
    public function getContest()
    {
        return $this->contest;
    }

    /**
     * Set contest
     *
     * @param Contest $contest
     * @return $this
     */
    public function setContest(Contest $contest)
    {
        $this->contest = $contest;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="dc_language_id", referencedColumnName="dc_name")
     */
    protected $language;

    /**
     * Get language
     *
     * @return Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set contest
     *
     * @param Language $language
     * @return $this
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;
        return $this;
    }
}

