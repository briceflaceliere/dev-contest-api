<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserContest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\UserContestRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class UserContest
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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startTs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endTs;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userContests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="UserContestTest", mappedBy="userContest")
     */
    protected $userContestTests;

    /**
     * @ORM\ManyToOne(targetEntity="Contest", inversedBy="userContests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $contest;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(referencedColumnName="dc_name")
     */
    protected $language;

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
