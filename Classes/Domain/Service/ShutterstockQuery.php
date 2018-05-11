<?php
namespace Vette\Shutterstock\Domain\Service;

use Neos\Cache\CacheAwareInterface;
use Neos\Flow\Annotations as Flow;

/**
 * A Shutterstock API Query
 */
class ShutterstockQuery implements CacheAwareInterface
{

    /**
     * @var string
     */
    protected $view = 'full';

    /**
     * @var string
     */
    protected $category;

    /**
     * @var string
     */
    protected $imageType;

    /**
     * @var bool
     */
    protected $safe = true;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $perPage = 1;

    /**
     * @var string
     */
    protected $query;

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
     * @return array
     */
    public function getResult() : array
    {
        return $this->shutterstockClient->query($this);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        $result = $this->shutterstockClient->query($this);
        $count = $result['total_count'];

        return $count > 1000 ? 1000 : $count;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return self
     */
    public function setPage(int $page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     * @return self
     */
    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * Get search term
     *
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query ? $this->query : '';
    }

    /**
     * Set search term
     *
     * @param string $query
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    /**
     * @return string
     */
    public function getView(): string
    {
        return $this->view;
    }

    /**
     * @param string $view
     */
    public function setView(string $view): void
    {
        $this->view = $view;
    }

    /**
     * @return bool
     */
    public function isSafe(): bool
    {
        return $this->safe;
    }

    /**
     * @param bool $safe
     */
    public function setSafe(bool $safe): void
    {
        $this->safe = $safe;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getImageType(): string
    {
        return $this->imageType;
    }

    /**
     * @param string $imageType
     */
    public function setImageType(string $imageType): void
    {
        $this->imageType = $imageType;
    }

    /**
     * Gets the cache entry identifier for this query
     *
     * @return string
     */
    public function getCacheEntryIdentifier(): string
    {
        return md5(json_encode($this->getParamsArray()));
    }

    /**
     * @return array
     */
    public function getParamsArray()
    {
        return array_filter([
            'view' => $this->view,
            'page' => $this->page,
            'per_page' => $this->perPage,
            'category' => $this->category,
            'image_type' => $this->imageType,
            'safe' => json_encode($this->safe),
            'query' => $this->query
        ]);
    }
}
