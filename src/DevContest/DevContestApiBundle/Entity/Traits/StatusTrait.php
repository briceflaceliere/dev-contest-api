<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 30/06/16
 * Time: 13:30
 */

namespace DevContest\DevContestApiBundle\Entity\Traits;


trait StatusTrait
{
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
    private $status;

    /**
     * Get authorised status list
     *
     * @return array
     */
    abstract function getStatusList();

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return bool
     */
    public function isStatus(string $status)
    {
        return $this->status === $status;
    }

    /**
     * @param string $status
     * @return $this
     * @throws \Exception Invalid status
     */
    public function setStatus(string $status)
    {
        $statusList = $this->getStatusList();
        if (!in_array($status, $statusList)) {
            throw new \Exception(sprintf('The status %s not defined', $status));
        }

        $this->status = $status;
        return $this;
    }


}