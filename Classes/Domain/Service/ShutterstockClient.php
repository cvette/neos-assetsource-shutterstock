<?php

namespace Vette\Shutterstock\Domain\Service;

use GuzzleHttp\Client as GuzzleClient;
use Neos\Flow\Annotations as Flow;
use Vette\Shutterstock\Domain\Model\Shutterstock\Image;
use Vette\Shutterstock\Domain\Model\Shutterstock\Result\ImageSearchResult;

/**
 * Shutterstock Client
 *
 * @Flow\Scope("singleton")
 */
class ShutterstockClient
{

    /**
     * @var string
     */
    protected $apiUrl = 'https://api.shutterstock.com/v2/';

    /**
     * @var string
     */
    protected $clientKey;

    /**
     * @var string
     */
    protected $clientSecret;

    /**
     * @var array
     */
    protected $defaultQueryParameters = array();

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $queryResponseCache = array();


    /**
     * Gets the http client
     *
     * @return GuzzleClient
     */
    protected function getClient(): GuzzleClient
    {
        if ($this->client === null) {
            $this->client = new GuzzleClient([
                'base_uri' => $this->apiUrl,
                'headers' => [
                    'Authorization' => 'Basic ' . $this->getAuthorizationHash(),
                    'Accept' => 'application/json'
                ]
            ]);
        }

        return $this->client;
    }

    /**
     * Gets the authorization hash
     *
     * @return string
     */
    protected function getAuthorizationHash(): string
    {
        return base64_encode(join(':', [$this->getClientKey(), $this->getClientSecret()]));
    }

    /**
     * Executes a shutterstock image search
     *
     * @param ShutterstockQuery $query
     * @return ImageSearchResult
     */
    public function searchImages(ShutterstockQuery $query): ImageSearchResult
    {
        if (isset($this->queryResponseCache[$query->getCacheEntryIdentifier()])) {
            return $this->queryResponseCache[$query->getCacheEntryIdentifier()];
        }

        $query = $this->applyDefaultQueryParameters($query);

        $response = $this->getClient()->get('images/search', ['query' => $query->getParametersArray()]);
        $response = json_decode($response->getBody(), true);
        $this->queryResponseCache[$query->getCacheEntryIdentifier()] = $response;

        return ImageSearchResult::createFromResponse($response);
    }

    /**
     * Gets an image by id
     *
     * @param string $identifier
     * @return Image
     */
    public function getImageById(string $identifier): Image
    {
        $response = $this->getClient()->get('images/' . $identifier, [
            'query' => ['view' => 'full']
        ]);

        $response = json_decode($response->getBody(), true);
        return Image::createFromResponse($response);
    }


    /**
     * Applies default query parameters
     *
     * @param ShutterstockQuery $query
     * @return ShutterstockQuery
     */
    protected function applyDefaultQueryParameters(ShutterstockQuery $query): ShutterstockQuery
    {
        $query->setParameter('view', 'full');

        foreach ($this->defaultQueryParameters as $name => $value) {
            $query->setParameter($name, $value);
        }

        return $query;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     * @return self
     */
    public function setApiUrl(string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * @param string $clientKey
     * @return self
     */
    public function setClientKey(string $clientKey): self
    {
        $this->clientKey = $clientKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     * @return self
     */
    public function setClientSecret(string $clientSecret): self
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefaultQueryParameters()
    {
        return $this->defaultQueryParameters;
    }

    /**
     * @param mixed $defaultQueryParameters
     * @return self
     */
    public function setDefaultQueryParameters($defaultQueryParameters): self
    {
        $this->defaultQueryParameters = $defaultQueryParameters;
        return $this;
    }
}
