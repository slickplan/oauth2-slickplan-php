<?php

namespace Slickplan\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class SlickplanResourceOwner implements ResourceOwnerInterface
{
    /**
     * Raw response
     *
     * @var array
     */
    protected array $response;

    /**
     * Creates new resource owner.
     *
     * @param array $response
     */
    public function __construct(array $response = [])
    {
        $this->response = $response;
    }

    /**
     * Get resource owner id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->response['id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->response['username'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->response['email'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return implode(' ', array_filter([$this->getFirstName(), $this->getLastName()]));
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->response['first_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->response['last_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getAccountUrl(): ?string
    {
        return $this->response['account_uri'] ?? null;
    }

    /**
     * Return all the owner details available as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->response;
    }
}
