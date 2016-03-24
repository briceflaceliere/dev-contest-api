<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/03/16
 * Time: 13:55
 */

namespace DevContest\DevContestApiBundle\Entity;

use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AuthCode extends BaseAuthCode
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(referencedColumnName="dc_id", nullable=false)
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(referencedColumnName="dc_id")
     */
    protected $user;
}