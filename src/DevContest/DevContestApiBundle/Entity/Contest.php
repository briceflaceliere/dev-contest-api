<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contest
 *
 * @ORM\Table(name="dc_contest", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="contest_name_idx", columns={"dc_name"})
 * })
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\ContestRepository")
 */
class Contest
{
    public function __construct() {
        $this->languages = new ArrayCollection();
        $this->contestTests = new ArrayCollection();
        $this->userContests = new ArrayCollection();
    }

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
     * @var string
     *
     * @ORM\Column(name="dc_name", type="string", length=100)
     */
    private $name;

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
     * @var string
     *
     * @ORM\Column(name="dc_logo", type="string", length=100, nullable=true)
     */
    private $logo;

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
     * @ORM\ManyToMany(targetEntity="Language")
     * @ORM\JoinTable(name="dc_contest_language",
     *   joinColumns={@ORM\JoinColumn(name="dc_contest_id", referencedColumnName="dc_id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="dc_language_id", referencedColumnName="dc_name")})
     */
    protected $languages;

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
     * @ORM\OneToMany(targetEntity="ContestTest", mappedBy="dc_contest_id")
     * @ORM\OrderBy({"dc_number" = "ASC"})
     */
    protected $contestTests;


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
     * @ORM\OneToMany(targetEntity="UserContest", mappedBy="dc_contest_id")
     */
    protected $userContests;


    /**
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

