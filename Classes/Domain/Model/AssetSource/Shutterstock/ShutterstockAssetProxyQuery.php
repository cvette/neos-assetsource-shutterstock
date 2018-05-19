<?php

namespace Vette\Shutterstock\Domain\Model\AssetSource\Shutterstock;

use Neos\Media\Domain\Model\AssetSource\AssetProxyQueryInterface;
use Neos\Media\Domain\Model\AssetSource\AssetProxyQueryResultInterface;
use Vette\Shutterstock\Domain\Service\ShutterstockQuery;

/**
 * Shutterstock AssetProxy Query
 */
class ShutterstockAssetProxyQuery implements AssetProxyQueryInterface
{

    /**
     * @var ShutterstockQuery
     */
    private $shutterstockQuery;

    /**
     * @var ShutterstockAssetSource
     */
    private $assetSource;


    /**
     * ShutterstockAssetProxyQuery constructor.
     *
     * @param ShutterstockQuery $shutterstockQuery
     * @param ShutterstockAssetSource $assetSource
     */
    public function __construct(ShutterstockQuery $shutterstockQuery, ShutterstockAssetSource $assetSource)
    {
        $this->shutterstockQuery = $shutterstockQuery;
        $this->assetSource = $assetSource;
    }

    public function setOffset(int $offset): void
    {
        $page = floor($offset / $this->getLimit()) + 1;
        $this->shutterstockQuery->setParameter('page', $page);
    }

    public function getOffset(): int
    {
        $page = $this->shutterstockQuery->getParameter('page');
        return $page * $this->getLimit() + 1;
    }

    public function setLimit(int $limit): void
    {
        $this->shutterstockQuery->setParameter('per_page', $limit);
    }

    public function getLimit(): int
    {
        return $this->shutterstockQuery->getParameter('per_page');
    }

    public function setSearchTerm(string $searchTerm)
    {
        $this->shutterstockQuery->setParameter('query', $searchTerm);
    }

    public function getSearchTerm()
    {
        return $this->shutterstockQuery->getParameter('query');
    }

    public function execute(): AssetProxyQueryResultInterface
    {
        return new ShutterstockAssetProxyQueryResult($this->shutterstockQuery->execute(), $this->assetSource);
    }

    public function count(): int
    {
        return $this->shutterstockQuery->count();
    }
}
