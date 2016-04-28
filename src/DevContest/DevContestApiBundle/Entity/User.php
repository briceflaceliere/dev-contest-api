<?php

namespace DevContest\DevContestApiBundle\Entity;

use DevContest\DevContestApiBundle\Security\OwnerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User class
 *
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\UserRepository")
 *
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity("username")
 */
class User implements UserInterface, EquatableInterface, OwnerInterface
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
     * @JMS\Groups({"all"})
     */
    protected $id;

    /**
     * Auth 0 Id
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true, nullable=true)
     *
     */
    protected $auth0Id;

    /**
     * Username
     *
     * @var string
     *
     * @ORM\Column(type="string", length=40, unique=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+/")
     */
    protected $username;

    /**
     * Email
     *
     * @var string
     *
     * @ORM\Column(type="string", length=100, unique=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"private"})
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * Picture
     *
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     *
     * @Assert\Url()
     */
    protected $picture;

    /**
     * Salt
     *
     * @ORM\Column(type="json_array")
     */
    protected $roles = ['ROLE_USER'];

    /**
     * @ORM\OneToMany(targetEntity="UserContest", mappedBy="user")
     */
    protected $userContests;

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
     * @return string
     */
    public function getAuth0Id()
    {
        return $this->auth0Id;
    }

    /**
     * @param string $auth0Id
     * @return $this
     */
    public function setAuth0Id($auth0Id)
    {
        $this->auth0Id = $auth0Id;

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return $this
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Set the roles of users
     *
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the roles of users
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add the role of users
     *
     * @param string $role
     * @return $this
     */
    public function addRole($role)
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * Remove the role of users
     *
     * @param string $role
     * @return $this
     */
    public function removeRole($role)
    {
        if (($key = array_search($role, $this->roles)) !== false) {
            unset($this->roles[$key]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get userContests
     *
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
     * @return null
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return void
     */
    public function eraseCredentials()
    {
    }

    /**
     * User is equal to UserInterface
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->getEmail() !== $user->getEmail()) {
            return false;
        }

        return true;
    }

    /**
     * @return UserInterface
     */
    public function getOwner()
    {
        return $this;
    }
}
