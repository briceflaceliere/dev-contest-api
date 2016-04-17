<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 13/04/16
 * Time: 13:05
 */

namespace DevContest\DevContestApiBundle\Provider;

use DevContest\DevContestApiBundle\Entity\User;
use DevContest\DevContestApiBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepository
     */
    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsernameForOauth($apiKey)
    {
        return $apiKey;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->loadUserByUsername($username);
        if ($user && $user instanceof User) {
           return $user;
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }



    public function supportsClass($class)
    {
        return $class === 'DevContest\DevContestApiBundle\Entity\User';
    }
} 