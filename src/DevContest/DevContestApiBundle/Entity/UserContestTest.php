<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserContestTest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\UserContestTestRepository")
 */
class UserContestTest
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
     * @ORM\Column(type="datetime", nullable=true)
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
     * @ORM\Column(type="datetime", nullable=true)
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
     * @ORM\Column(type="integer", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="UserContest", inversedBy="userContestTests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $userContest;

    /**
     * @return UserContest
     */
    public function getUserContest()
    {
        return $this->userContest;
    }

    /**
     * @param UserContest $userContest
     * @return $this
     */
    public function setUserContest(UserContest $userContest)
    {
        $this->userContest = $userContest;
        return $this;
    }

    /**
     * @ORM\ManyToOne(targetEntity="ContestTest", inversedBy="userContestTests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $contestTest;

    /**
     * @return UserContest
     */
    public function getContestTest()
    {
        return $this->contestTest;
    }

    /**
     * @param ContestTest $contestTest
     * @return $this
     */
    public function setContestTest(ContestTest $contestTest)
    {
        $this->contestTest = $contestTest;
        return $this;
    }


}

