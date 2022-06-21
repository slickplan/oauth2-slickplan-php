<?php

namespace Slickplan\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Slickplan extends AbstractProvider
{
    use BearerAuthorizationTrait;

    const BASE_URL = 'https://slickplan.com/api/v1/';

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl(): string
    {
        return self::BASE_URL . 'authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array  $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return self::BASE_URL . 'token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return self::BASE_URL . 'me';
    }

    /**
     * Get the default scopes used by Slickplan provider.
     *
     * @return array
     */
    protected function getDefaultScopes(): array
    {
        return ['all_write'];
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (isset($data['error'], $data['error_description'])) {
            throw new IdentityProviderException(
                $data['error_description'],
                $response->getStatusCode(),
                $response->getBody()
            );
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return SlickplanResourceOwner
     */
    protected function createResourceOwner(array $response, AccessToken $token): SlickplanResourceOwner
    {
        return new SlickplanResourceOwner($response);
    }
}
