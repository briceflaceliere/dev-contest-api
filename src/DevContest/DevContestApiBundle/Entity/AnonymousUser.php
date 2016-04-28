<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/04/16
 * Time: 13:21
 */

namespace DevContest\DevContestApiBundle\Entity;

/**
 * Class AnonymousUser
 * @package DevContest\DevContestApiBundle\Entity
 */
class AnonymousUser extends User
{
    protected $roles = ['IS_AUTHENTICATED_ANONYMOUSLY'];
}
