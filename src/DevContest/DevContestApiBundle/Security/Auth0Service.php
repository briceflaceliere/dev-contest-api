<?php

namespace DevContest\DevContestApiBundle\Security;

use Auth0\JWTAuthBundle\Security\Auth0Service as BaseAuth0Service;
use Auth0\SDK\Auth0JWT;

/**
 * @author german
 *
 * Service that provides access to the Auth0 SDK and JWT validation
 */
class Auth0Service extends BaseAuth0Service
{
    protected $client_id;
    protected $client_secret;
    protected $domain;
    protected $oauth_client;

    public function __construct($client_id, $client_secret, $domain, $secret_base64_encoded)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->domain = $domain;
        $this->secret_base64_encoded = $secret_base64_encoded;

        parent::__construct($client_id, $client_secret, $domain, $secret_base64_encoded);
    }

    /**
     * Encode the auth0 JWT Token
     *
     * @param $decToken
     * @param int $lifetime
     * @return string
     */
    public function encodeJWT($decToken, $lifetime = 36000)
    {
        return Auth0JWT::encode($this->client_id, $this->client_secret, null, $decToken, $lifetime);
    }
}
