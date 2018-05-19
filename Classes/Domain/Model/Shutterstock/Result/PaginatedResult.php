<?php

namespace Vette\Shutterstock\Domain\Model\Shutterstock\Result;

use Neos\Flow\Annotations as Flow;

/**
 * Paginated Result
 *
 * @Flow\Proxy(enabled=false)
 */
abstract class PaginatedResult
{

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $perPage;

    /**
     * @var int
     */
    protected $totalCount;

    /**
     * @var string
     */
    protected $searchId;

    /**
     * @var array
     */
    protected $data;

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
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     * @return self
     */
    public function setTotalCount(int $totalCount): self
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getSearchId(): string
    {
        return $this->searchId;
    }

    /**
     * @param string $searchId
     * @return self
     */
    public function setSearchId(string $searchId): self
    {
        $this->searchId = $searchId;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
}
