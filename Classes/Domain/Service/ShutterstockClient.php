<?php
namespace Vette\Shutterstock\Domain\Service;

use GuzzleHttp\Client as GuzzleClient;
use Neos\Flow\Annotations as Flow;

/**
 * Shutterstock Service
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
     * @var
     */
    protected $queryParams = array();

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
    protected function getClient() : GuzzleClient
    {
        if ($this->client === null) {
            $this->client = new GuzzleClient([
                'base_url' => [ $this->apiUrl,  []],
                'defaults' => [
                    'exceptions' => false,
                    'headers' => [
                        'Authorization' => 'Basic ' . $this->getAuthorizationHash(),
                        'Accept'        => 'application/json'
                    ]
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
    protected function getAuthorizationHash()
    {
        return base64_encode(join(':', [$this->getClientKey(), $this->getClientSecret()]));
    }

    /**
     * Query Shutterstock
     *
     * @param ShutterstockQuery $query
     * @return array
     */
    public function query(ShutterstockQuery $query): array
    {
        if (isset($this->queryResponseCache[$query->getCacheEntryIdentifier()])) {
            return $this->queryResponseCache[$query->getCacheEntryIdentifier()];
        }

        $queryParams = $this->getQueryParams();
        if (isset($queryParams['imageType'])) {
            $query->setImageType($queryParams['imageType']);
        }

        if (isset($queryParams['category'])) {
            $query->setCategory($queryParams['category']);
        }

        if (isset($queryParams['safe'])) {
            $query->setSafe($queryParams['safe']);
        }

        $response = $this->getClient()->get('images/search', ['query' => $query->getParamsArray()]);
        $response = json_decode($response->getBody(), true);

        $this->queryResponseCache[$query->getCacheEntryIdentifier()] = $response;

        return $response;
    }

    /**
     * Gets an image by id
     *
     * @param string $identifier
     * @return \GuzzleHttp\Message\FutureResponse|\GuzzleHttp\Message\ResponseInterface|mixed|null
     */
    public function getById(string $identifier)
    {
        $response = $this->getClient()->get('images/' . $identifier, [
            'query' => ['view' => 'full']
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
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
     */
    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
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
     */
    public function setClientKey(string $clientKey): void
    {
        $this->clientKey = $clientKey;
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
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return mixed
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * @param mixed $queryParams
     */
    public function setQueryParams($queryParams): void
    {
        $this->queryParams = $queryParams;
    }
}
