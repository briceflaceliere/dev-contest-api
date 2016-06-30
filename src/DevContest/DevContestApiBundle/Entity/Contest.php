<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DevContest\DevContestApiBundle\Entity\Traits\StatusTrait;

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
    use StatusTrait;

    const STATUS_UNSTARTED = 'STATUS_UNSTARTED';
    const STATUS_STARTED   = 'STATUS_STARTED';
    const STATUS_COMPLETED = 'STATUS_COMPLETED';
    const STATUS_DISABLED  = 'STATUS_DISABLED';

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
     * @ORM\OneToMany(targetEntity="ContestStep", mappedBy="contest")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $contestSteps;

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
        $this->contestSteps = new ArrayCollection();
        $this->userContests = new ArrayCollection();
        $this->setStatus(self::STATUS_UNSTARTED);
    }

    /**
     * @return array
     */
    function getStatusList()
    {
        return [
            self::STATUS_UNSTARTED,
            self::STATUS_STARTED,
            self::STATUS_COMPLETED,
            self::STATUS_DISABLED
        ];
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
    public function getContestSteps()
    {
        return $this->contestSteps;
    }

    /**
     * Set contest test
     *
     * @param ArrayCollection $contestTests
     * @return $this
     */
    public function setContestSteps(ArrayCollection $contestTests)
    {
        $this->contestSteps = $contestTests;

        return $this;
    }

    /**
     * Add contest step
     *
     * @param ContestStep $contestStep
     * @return $this
     */
    public function addContestStep(ContestStep $contestStep)
    {
        $this->contestSteps->add($contestStep);

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
