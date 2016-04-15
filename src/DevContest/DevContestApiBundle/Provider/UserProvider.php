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

class UserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface
{
    /**
     * @var UserRepository
     */
    protected $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->userRepository->loadUserByUsername($username, $username);
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

    /**
     * Loads the user by a given UserResponseInterface object.
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();
        $identifier = $response->getResponse()[$response->getPath('identifier')];
//var_dump($response); exit();
        //Search by identifier
        $user = $this->userRepository->findOneBy([$resourceOwnerName . 'Id' => $identifier]);

        //Search by email
        if (!$user) {
            $user = $this->userRepository->findOneByEmail($response->getEmail());
        }

        if (!$user) {
            $user = new User();
        }

        $user->setUsername($response->getUsername());
        $user->setEmail($response->getEmail());
        $setter = 'set' . ucfirst($resourceOwnerName) . 'Id';
        $user->$setter($identifier);

        $this->userRepository->update($user);

        return $user;
    }


    public function supportsClass($class)
    {
        return $class === 'DevContest\DevContestApiBundle\Entity\User';
    }
} 