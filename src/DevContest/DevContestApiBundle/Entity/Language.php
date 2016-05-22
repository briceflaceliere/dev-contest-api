<?php

namespace DevContest\DevContestApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Language
 *
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(name="language_name_idx", columns={"dc_name"})
 * })
 * @ORM\Entity(repositoryClass="DevContest\DevContestApiBundle\Repository\LanguageRepository")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @JMS\ExclusionPolicy("all")
 * @UniqueEntity("name")
 */
class Language
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
     * @ORM\Column(type="string", length=40)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\Since("0.1")
     * @JMS\Groups({"all"})
     */
    protected $name;

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
    protected $logo;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set Logo
     *
     * @param string $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }
}
