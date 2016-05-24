<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserContestTest
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\UserContestTestRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
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
     * @ORM\ManyToOne(targetEntity="UserContest", inversedBy="userContestTests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $userContest;

    /**
     * @ORM\ManyToOne(targetEntity="ContestStep", inversedBy="userContestTests")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $contestStep;

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
     * @return UserContest
     */
    public function getContestStep()
    {
        return $this->contestStep;
    }

    /**
     * @param ContestStep $contestStep
     * @return $this
     */
    public function setContestStep(ContestStep $contestStep)
    {
        $this->contestStep = $contestStep;

        return $this;
    }
}
