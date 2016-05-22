<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 28/04/16
 * Time: 12:53
 */

namespace DevContest\DevContestApiBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Class OwnerVoter
 * @package DevContest\DevContestApiBundle\Security
 */
class OwnerVoter implements VoterInterface
{
    /**
     * Checks if the voter supports the given attribute.
     *
     * @param mixed $attribute An attribute (usually the attribute name string)
     *
     * @return bool true if this Voter supports the attribute, false otherwise
     *
     * @deprecated since version 2.8, to be removed in 3.0.
     */
    public function supportsAttribute($attribute)
    {
        return $attribute == 'ROLE_OWNER';
    }

    /**
     * Checks if the voter supports the given class.
     *
     * @param string $class A class name
     *
     * @return bool true if this Voter can process the class
     *
     * @deprecated since version 2.8, to be removed in 3.0.
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token      A TokenInterface instance
     * @param object|null    $object     The object to secure
     * @param array          $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $vote = VoterInterface::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if (false === $this->supportsAttribute($attribute)) {
                continue;
            }

            if (!$object instanceof OwnerInterface) {
                continue;
            }

            if ($token->getUser()->isEqualTo($object->getOwner())) {
                $vote = VoterInterface::ACCESS_GRANTED;
            }
        }

        return $vote;
    }
}
