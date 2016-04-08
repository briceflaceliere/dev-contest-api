<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User class
 *
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="nickname_idx", columns={"dc_nickname"})
 * })
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\UserRepository")
 *
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity("nickname")
 */
class User
{

    /**
     * Identifier
     *
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\Since("0.1")
     */
    protected $id;

    /**
     * Nickname
     *
     * @var string
     *
     * @ORM\Column(type="string", length=40)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+/")
     */
    protected $nickname;

    /**
     * @ORM\OneToMany(targetEntity="UserContest", mappedBy="user")
     */
    protected $userContests;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $githubId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userContests = new ArrayCollection();
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
     * Get Nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set Nickname
     *
     * @param string $nickname
     * @return $this;
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserContests()
    {
        return $this->userContests;
    }

    /**
     * Set user contests
     *
     * @param ArrayCollection $userContests
     * @return $this
     */
    public function setUserContests(ArrayCollection $userContests)
    {
        $this->userContests = $userContests;

        return $this;
    }

    /**
     * Add contest test
     *
     * @param UserContest $userContest
     * @return $this
     */
    public function addUserContest(UserContest $userContest)
    {
        $this->userContest->add($userContest);

        return $this;
    }

    /**
     * @return string
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * @param string $githubId
     * @return $this
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;

        return $this;
    }
}
