<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 28/04/16
 * Time: 13:05
 */

namespace DevContest\DevContestApiBundle\Security;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface OwnerInterface
 * @package DevContest\DevContestApiBundle\Security
 */
interface OwnerInterface
{
    /**
     * @return UserInterface
     */
    public function getOwner();
}
