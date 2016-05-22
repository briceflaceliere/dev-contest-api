<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 22/04/16
 * Time: 12:58
 */

namespace DevContest\DevContestApiBundle\Security;

use Auth0\JWTAuthBundle\Security\Core\JWTUserProviderInterface;
use DevContest\DevContestApiBundle\Entity\AnonymousUser;
use DevContest\DevContestApiBundle\Entity\User;
use DevContest\DevContestApiBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class A0UserProvider
 * @package DevContest\DevContestApiBundle\Security
 */
class A0UserProvider implements JWTUserProviderInterface
{

    /**
     * @var Auth0Service
     */
    protected $auth0Service;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param Auth0Service   $auth0Service
     * @param UserRepository $userRepository
     */
    public function __construct(Auth0Service $auth0Service, UserRepository $userRepository)
    {
        $this->auth0Service = $auth0Service;
        $this->userRepository = $userRepository;
    }

    /**
     * Load user by auth0 jwt token
     * @param string $jwt
     * @return \Auth0\JWTAuthBundle\Security\Core\UserInterface|User
     * @throws \Exception
     */
    public function loadUserByJWT($jwt)
    {
        // Devcontest JWT
        if (isset($jwt->user_id) && substr_count($jwt->user_id, 'devcontest')) {
            list($connect, $localId) = explode('|', $jwt->user_id);
            return $this->userRepository->find($localId);
        }

        // Auth0 JWT
        $data = $this->auth0Service->getUserProfileByA0UID($jwt->token, $jwt->sub);

        $user = $this->userRepository->findOneByEmail($data['email']);

        if (!$user) {
            $user = $this->userRepository->findOneByAuth0Id($data['user_id']);
        }

        if (!$user) {
            $user = new User();
        }

        $this->userRepository->updateUserFromAuth0($user, $data);

        return $user;
    }

    /**
     * @param string $username
     * @return UserInterface|void
     * @throws NotImplementedException
     */
    public function loadUserByUsername($username)
    {
        return $this->userRepository->findOneByUsername($username);
    }

    /**
     * @return \Auth0\JWTAuthBundle\Security\Core\UserInterface|AnonymousUser
     */
    public function getAnonymousUser()
    {
        return new AnonymousUser();
    }

    /**
     * @param UserInterface $user
     * @return UserInterface|void
     * @throws NotImplementedException
     * @throws UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'AppBundle\Security\A0User';
    }
}
