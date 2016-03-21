<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 *
 * @ORM\Table(name="dc_test")
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\TestRepository")
 */
class Test
{
    public function __construct() {
        $this->contestTests = new ArrayCollection();
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
     * @ORM\Column(name="dc_title", type="string", length=255)
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
     * @ORM\JoinTable(name="dc_test_language",
     *   joinColumns={@ORM\JoinColumn(name="dc_test_id", referencedColumnName="dc_id")},
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

}

