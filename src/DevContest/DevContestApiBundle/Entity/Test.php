<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Test
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\TestRepository")
 * @JMS\ExclusionPolicy("all")
 */
class Test
{
    public function __construct() {
        $this->contestTests = new ArrayCollection();
    }

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
     * @ORM\Column(type="string", length=255)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+/")
     */
    private $title;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Test
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @var text
     *
     * @ORM\Column(type="text")
     * 
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+/")
     */
    private $description;

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Test
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * @ORM\OneToMany(targetEntity="ContestTest", mappedBy="dc_test_id")
     */
    protected $contestTests;

    /**
     * @return mixed
     */
    public function getContestTests()
    {
        return $this->contestTests;
    }

    /**
     * @param mixed $contestTests
     * @return $this
     */
    public function setContestTests(ArrayCollection $contestTests)
    {
        $this->contestTests = $contestTests;
        return $this;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Language")
     * @ORM\JoinTable(
     *   joinColumns={@ORM\JoinColumn(referencedColumnName="dc_id")},
     *   inverseJoinColumns={@ORM\JoinColumn(referencedColumnName="dc_name")})
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

}

