<?php
/**
 * Created by PhpStorm.
 * User: brice
 * Date: 15/04/16
 * Time: 13:53
 */

namespace DevContest\DevContestApiBundle\Security;

/**
 * Class OauthLogin
 * @package DevContest\DevContestApiBundle\Security
 */
class OauthLogin
{

    /**
     * Oauth provider
     *
     * @var string
     */
    protected $provider;

    /**
     * Oauth access token
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Get oauth provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set oauth provider
     *
     * @param string $provider
     * @return $this
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get oauth access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set oauth access token
     *
     * @param string $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

} 