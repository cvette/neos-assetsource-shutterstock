<?php
namespace Vette\Shutterstock\Domain\Model\AssetSource\Shutterstock;

use Neos\Media\Domain\Model\AssetSource\AssetProxy\AssetProxyInterface;
use Neos\Media\Domain\Model\AssetSource\AssetProxyQueryResultInterface;
use Neos\Media\Domain\Model\AssetSource\AssetProxyRepositoryInterface;
use Neos\Media\Domain\Model\AssetSource\AssetTypeFilter;
use Neos\Media\Domain\Model\Tag;
use Vette\Shutterstock\Domain\Service\ShutterstockQuery;

/**
 * Shutterstock AssetProxy Repository
 */
class ShutterstockAssetProxyRepository implements AssetProxyRepositoryInterface
{

    /**
     * @var ShutterstockAssetSource
     */
    protected $assetSource;


    /**
     * Constructor
     *
     * @param ShutterstockAssetSource $assetSource
     */
    public function __construct(ShutterstockAssetSource $assetSource)
    {
        $this->assetSource = $assetSource;
    }

    /**
     * Gets the asset proxy for an identifier
     *
     * @param string $identifier
     * @return AssetProxyInterface
     */
    public function getAssetProxy(string $identifier): AssetProxyInterface
    {
        $data = $this->assetSource->getClient()->getById($identifier);
        return new ShutterstockAssetProxy($data, $this->assetSource);
    }

    /**
     * Filters assets by type
     *
     * @param AssetTypeFilter|null $assetType
     */
    public function filterByType(AssetTypeFilter $assetType = null): void
    {
        //only images are supported for now
    }

    /**
     * Finds all assets
     *
     * @return AssetProxyQueryResultInterface
     */
    public function findAll(): AssetProxyQueryResultInterface
    {
        $query = new ShutterstockQuery();
        return new ShutterstockAssetProxyQueryResult($query->execute(), $this->assetSource);
    }

    /**
     * Finds assets by search term
     *
     * @param string $searchTerm
     * @return AssetProxyQueryResultInterface
     */
    public function findBySearchTerm(string $searchTerm): AssetProxyQueryResultInterface
    {
        $query = new ShutterstockQuery();
        $query->setQuery($searchTerm);
        return new ShutterstockAssetProxyQueryResult($query->execute(), $this->assetSource);
    }

    /**
     * Finds assets by tag
     *
     * @param Tag $tag
     * @return AssetProxyQueryResultInterface
     */
    public function findByTag(Tag $tag): AssetProxyQueryResultInterface
    {
        throw new \RuntimeException('Unsupported operation: ' . __METHOD__, 1510060444);
    }

    /**
     * Finds untagged assets
     *
     * @return AssetProxyQueryResultInterface
     */
    public function findUntagged(): AssetProxyQueryResultInterface
    {
        throw new \RuntimeException('Unsupported operation: ' . __METHOD__, 1510060444);
    }

    /**
     * Counts all assets
     *
     * @return int
     */
    public function countAll(): int
    {
        return 1000;
    }
}
