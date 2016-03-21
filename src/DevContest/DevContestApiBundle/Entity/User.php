<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="dc_user", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="nickname_idx", columns={"dc_nickname"})
 * })
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\UserRepository")
 */
class User
{
    public function __construct() {
        $this->userContexts = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="dc_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


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
     * @var string
     *
     * @ORM\Column(name="dc_nickname", type="string", length=40)
     */
    protected $nickname;

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
     * @ORM\OneToMany(targetEntity="UserContest", mappedBy="dc_user_id")
     */
    protected $userContexts;


    /**
     * @return ArrayCollection
     */
    public function getUserContests()
    {
        return $this->userContexts;
    }

    /**
     * Set contest test
     *
     * @param ArrayCollection $userContexts
     * @return $this
     */
    public function setContestTests(ArrayCollection $userContexts)
    {
        $this->userContexts = $userContexts;
        return $this;
    }

    /**
     * Add contest test
     *
     * @param UserContest $userContext
     * @return $this
     */
    public function addContestTest(UserContest $userContext)
    {
        $this->userContexts->add($userContext);
        return $this;
    }

}

