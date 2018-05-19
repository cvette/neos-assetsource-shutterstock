<?php
namespace Vette\Shutterstock\Domain\Service;

use Neos\Cache\CacheAwareInterface;
use Neos\Flow\Annotations as Flow;
use Vette\Shutterstock\Domain\Model\Shutterstock\Result\PaginatedResult;

/**
 * A Shutterstock API Query
 */
class ShutterstockQuery implements CacheAwareInterface
{

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @Flow\Inject
     * @var ShutterstockClient
     */
    protected $shutterstockClient;


    /**
     * @return ShutterstockQueryResult
     */
    public function execute(): ShutterstockQueryResult
    {
        return new ShutterstockQueryResult($this);
    }

    /**
     * @return PaginatedResult
     */
    public function getResult() : PaginatedResult
    {
        return $this->shutterstockClient->searchImages($this);
    }

    /**
     * Gets the cache entry identifier for this query
     *
     * @return string
     */
    public function getCacheEntryIdentifier(): string
    {
        return md5(json_encode($this->getParametersArray()));
    }

    /**
     * Sets a query parameter
     *
     * @param string $name
     * @param $value
     * @return self
     */
    public function setParameter(string $name, $value): self
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * Gets a query parameter
     *
     * @param string $name
     * @return mixed
     */
    public function getParameter(string $name)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }

        return null;
    }

    /**
     * @return array
     */
    public function getParametersArray(): array
    {
        return $this->parameters;
    }
}
