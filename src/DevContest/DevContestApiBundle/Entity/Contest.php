<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Contest entity
 *
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="contest_name_idx", columns={"dc_name"})
 * })
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\ContestRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity("name")
 */
class Contest
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
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    private $logo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    private $startTs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    private $endTs;

    /**
     * @ORM\OneToMany(targetEntity="ContestTest", mappedBy="dc_contest_id")
     * @ORM\OrderBy({"dc_number" = "ASC"})
     */
    protected $contestTests;

    /**
     * @ORM\OneToMany(targetEntity="UserContest", mappedBy="contest")
     */
    protected $userContests;

    /**
     * @ORM\ManyToMany(targetEntity="Language")
     * @ORM\JoinTable(
     *   joinColumns={@ORM\JoinColumn(referencedColumnName="dc_id")},
     *   inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="dc_id")})
     *
     * @JMS\Expose
     * @JMS\Type("DateTime")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    protected $languages;

    /**
     * Contructor
     */
    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->contestTests = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Contest
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Contest
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
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
     * Get languages
     *
     * @return ArrayCollection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set languages
     *
     * @param ArrayCollection $languages
     * @return $this
     */
    public function setLanguages(ArrayCollection $languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * Add language
     *
     * @param Language $language
     * @return $this
     */
    public function addLanguage(Language $language)
    {
        $this->languages->add($language);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getContestTests()
    {
        return $this->contestTests;
    }

    /**
     * Set contest test
     *
     * @param ArrayCollection $contestTests
     * @return $this
     */
    public function setContestTests(ArrayCollection $contestTests)
    {
        $this->contestTests = $contestTests;

        return $this;
    }

    /**
     * Add contest test
     *
     * @param ContestTest $contestTest
     * @return $this
     */
    public function addContestTest(ContestTest $contestTest)
    {
        $this->contestTests->add($contestTest);

        return $this;
    }

    /**
     * Get user contests
     *
     * @return ArrayCollection
     */
    public function getUserContests()
    {
        return $this->userContests;
    }

    /**
     * Set contest test
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
        $this->userContests->add($userContest);

        return $this;
    }
}
