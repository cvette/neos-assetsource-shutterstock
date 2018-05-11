<?php
namespace Vette\Shutterstock\Domain\Model\AssetSource\Shutterstock;

use Neos\Media\Domain\Model\AssetSource\AssetProxy\AssetProxyInterface;
use Neos\Media\Domain\Model\AssetSource\AssetProxyQueryInterface;
use Neos\Media\Domain\Model\AssetSource\AssetProxyQueryResultInterface;
use Vette\Shutterstock\Domain\Service\ShutterstockQueryResult;

/**
 * Shutterstock AssetProxyQueryResult
 */
class ShutterstockAssetProxyQueryResult implements AssetProxyQueryResultInterface
{
    /**
     * @var ShutterstockAssetSource
     */
    private $assetSource;

    /**
     * @var ShutterstockQueryResult
     */
    private $shutterstockQueryResult;

    /**
     * @var ShutterstockAssetProxyQuery
     */
    private $query;


    public function __construct(ShutterstockQueryResult $shutterstockQueryResult, ShutterstockAssetSource $assetSource)
    {
        $this->shutterstockQueryResult = $shutterstockQueryResult;
        $this->assetSource = $assetSource;
    }

    public function getQuery(): AssetProxyQueryInterface
    {
        if ($this->query === null) {
            $this->query = new ShutterstockAssetProxyQuery($this->shutterstockQueryResult->getQuery(), $this->assetSource);
        }

        return $this->query;
    }

    public function getFirst(): ?AssetProxyInterface
    {
        throw new \RuntimeException('Unsupported operation: ' . __METHOD__, 1510060444);
    }

    public function toArray(): array
    {
        return array();
    }

    public function current(): ?AssetProxyInterface
    {
        $data = $this->shutterstockQueryResult->current();
        if (is_array($data)) {
            return new ShutterstockAssetProxy($data, $this->assetSource);
        } else {
            return null;
        }
    }

    public function next()
    {
        $this->shutterstockQueryResult->next();
    }

    public function key()
    {
        return $this->shutterstockQueryResult->key();
    }

    public function valid()
    {
        return $this->shutterstockQueryResult->valid();
    }

    public function rewind()
    {
        $this->shutterstockQueryResult->rewind();
    }

    public function offsetExists($offset)
    {
        if ($offset === null) {
            $offset = 0;
        }

        $this->shutterstockQueryResult->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return new ShutterstockAssetProxy($this->shutterstockQueryResult->offsetGet($offset), $this->assetSource);
    }

    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException('Unsupported operation: ' . __METHOD__, 1510060444);
    }

    public function offsetUnset($offset)
    {
        throw new \RuntimeException('Unsupported operation: ' . __METHOD__, 1510060444);
    }

    public function count()
    {
        return $this->shutterstockQueryResult->count();
    }

}
